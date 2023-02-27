<?php

declare(strict_types=1);

namespace Luxdone\Validators;

interface CurrencyValidatorInterface
{
    public function validate(?string $currency): ?string;
}
