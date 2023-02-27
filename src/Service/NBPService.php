<?php

declare(strict_types=1);

namespace Luxdone\Service;

use Luxdone\Connectors\CurlConnectorInterface;
use Luxdone\Validators\DateRangeValidatorInterface;
use Luxdone\Validators\NBPDateRangeValidator;

class NBPService implements ServiceInterface
{
    protected const NBP_URL = 'http://api.nbp.pl/api/exchangerates/rates/{table}/{currency}/{startDate}/{endDate}/';
    protected const TABLE_TYPE = 'C'; //bid ask table

    public function __construct(
        protected readonly CurlConnectorInterface $curlConnector,
        protected readonly DateRangeValidatorInterface $NBPDateRangeValidator,
    ) {}

    public function getData(array $data): ?array
    {
        $errors = [];
        if (empty($dates = $this->prepareDates($data))) {
            $errors[] = sprintf('Could not create dates from %s, %s', $data['start_date'], $data['end_date']);
        }

        $result = [];
        $currency = $data['currency'];
        foreach ($dates as $date) {
            $startDate = $date['start_date'];
            $endDate = $date['end_date'];

            $url = str_replace(
                [
                    '{table}',
                    '{currency}',
                    '{startDate}',
                    '{endDate}',
                ],
                [
                    $this::TABLE_TYPE,
                    $currency,
                    $startDate,
                    $endDate,
                ],
                $this::NBP_URL
            );

            $response = $this->curlConnector->getData($url);

            if ($data = json_decode($response)) {
                $result = array_merge($result, $data->rates ?? []);
            } else {
                $errors[] = sprintf(
                    'Got response: "%s", currency: "%s", dates "%s" - "%s".',
                    $response,
                    $currency,
                    $startDate,
                    $endDate
                );
            }

        }

        if (!empty($errors)) {
            $result['errors'] = $errors;
        }

        return $result;
    }

    protected function prepareDates(array $data): array
    {
        $dates = [];

        // swap dates if were given in wrong order
        if ($data['start_date'] > $data['end_date']) {
            $tmp = $data['start_date'];
            $data['start_date'] = $data['end_date'];
            $data['end_date'] = $tmp;

            unset($tmp);
        }

        if ($this->NBPDateRangeValidator->validate($data['start_date'], $data['end_date'])) {
            try {
                $start = new \DateTime($data['start_date']);
                $end = new \DateTime($data['end_date']);
                $interval = new \DateInterval(sprintf('P%sD', NBPDateRangeValidator::MAX_DAYS));
                $dateRange = new \DatePeriod($start, $interval, $end);
            } catch (\Exception $e) {
                //try-catch for DateTime, log error
                return [];
            }

            $firstLoop = true;
            $tmpArr = [];
            foreach ($dateRange as $date) {
                if ($firstLoop) {
                    $tmpArr['start_date'] = $date->format('Y-m-d');
                    $firstLoop = false;
                } else {
                    $tmpArr['end_date'] = $date->format('Y-m-d');
                    $dates[] = $tmpArr;
                    $tmpArr = [];
                    $tmpArr['start_date'] = $date->modify('+1 days')->format('Y-m-d');
                }
            }

            $tmpArr['end_date'] = $end->format('Y-m-d');
            $dates[] = $tmpArr;
        } else {
            $dates = [$data];
        }

        return $dates;
    }
}
