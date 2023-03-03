<?php

declare(strict_types=1);

namespace AvgRates\Validators;

interface ValidatorInterface
{
    public function validate(array $data): array;
}
