<?php

declare(strict_types=1);

namespace AvgRates\Validators;

interface CurrencyValidatorInterface
{
    public function validate(?string $currency): ?string;
}
