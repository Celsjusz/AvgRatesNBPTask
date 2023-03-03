<?php

declare(strict_types=1);

namespace AvgRates\Validators;

interface DateValidatorInterface
{
    public function validate(?string $date): ?string;
}
