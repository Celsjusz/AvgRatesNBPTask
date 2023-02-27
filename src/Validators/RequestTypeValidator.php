<?php

declare(strict_types=1);

namespace Luxdone\Validators;

class RequestTypeValidator implements RequestTypeValidatorInterface
{
    public function validate(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return 'Other requests than GET are not supported!';
        }

        return null;
    }
}
