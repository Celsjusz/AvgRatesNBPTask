<?php

declare(strict_types=1);

namespace AvgRates\Validators;

interface RequestTypeValidatorInterface
{
    public function validate(): ?string;
}
