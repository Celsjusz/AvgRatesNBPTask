<?php

declare(strict_types=1);

namespace Luxdone\Validators;

interface DateValidatorInterface
{
    public function validate(?string $date): ?string;
}
