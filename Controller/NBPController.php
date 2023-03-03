<?php

declare(strict_types=1);

namespace AvgRates\Controller;

use AvgRates\Calculators\AverageBidCalculatorInterface;
use AvgRates\Service\ServiceInterface;
use AvgRates\Validators\ValidatorInterface;

class NBPController implements ControllerInterface
{
    public function __construct(
        protected readonly ValidatorInterface $validator,
        protected readonly ServiceInterface $NBPService,
        protected readonly AverageBidCalculatorInterface $averageBidCalculator,
    ) {}

    public function process(array $request): array
    {
        $errors = $this->validator->validate($request);

        if (!empty($errors)) {
            return $this->returnErrors($errors);
        }

        $data = $this->NBPService->getData($request);

        if (!empty($data['errors'])) {
            return $this->returnErrors($data['errors']);
        }

        return [
            'status' => 1,
            'data' => [
                'average_price' => $this->averageBidCalculator->calculate($data),
            ],
        ];
    }

    private function returnErrors(array $errors): array
    {
        return [
            'status' => 0,
            'data' => [
                'message' => $errors,
            ],
        ];
    }
}
