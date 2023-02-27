<?php

declare(strict_types=1);

namespace Luxdone\Validators;

class DateValidator implements DateValidatorInterface
{
    /** @var string */
    protected const VALID_FORMAT = 'Y-m-d';

    public function validate(?string $date): ?string
    {
        $validDate = \DateTime::createFromFormat($this::VALID_FORMAT, $date ?? '');
        if ($validDate && $validDate->format($this::VALID_FORMAT) === $date) {
            return null;
        }

        return sprintf('Date "%s" is in incorrect format. Please use YYYY-MM-DD.', $date);
    }
}
