<?php

declare(strict_types=1);

namespace AvgRates\Validators;

interface DateRangeValidatorInterface
{
    public function validate(string $startDate, string $endDate): ?string;
}
