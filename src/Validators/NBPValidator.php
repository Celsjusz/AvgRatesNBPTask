<?php

declare(strict_types=1);

namespace AvgRates\Validators;

class NBPValidator implements ValidatorInterface
{
    public function __construct(
        protected readonly CurrencyValidatorInterface $currencyValidator,
        protected readonly DateValidatorInterface $dateValidator,
        protected readonly RequestTypeValidatorInterface $requestTypeValidator,
    ) {}

    public function validate(array $data): array
    {
        $errors = [];

        $errors[] = $this->currencyValidator->validate($data['currency']);
        $errors[] = $this->dateValidator->validate($data['start_date']);
        $errors[] = $this->dateValidator->validate($data['end_date']);
        $errors[] = $this->requestTypeValidator->validate();

        // don't preserve keys, because we don't want to show how many validators we use
        return array_values(array_filter($errors));
    }
}
