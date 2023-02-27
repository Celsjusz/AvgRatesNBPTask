<?php

declare(strict_types=1);

namespace Luxdone\Validators;

interface RequestTypeValidatorInterface
{
    public function validate(): ?string;
}
