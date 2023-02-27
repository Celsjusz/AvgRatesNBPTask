<?php

declare(strict_types=1);

namespace Luxdone\Validators;

interface ValidatorInterface
{
    public function validate(array $data): array;
}
