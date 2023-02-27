<?php

declare(strict_types=1);

namespace Luxdone\Validators;

class NBPDateRangeValidator implements DateRangeValidatorInterface
{
    public const MAX_DAYS = 93; // max days per 1 request to NBP

    public function validate(string $startDate, string $endDate): ?string
    {
        try {
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
        } catch (\Exception $e) {
            // try-catch for DateTime, although this won't happen since we are validating dates before,
            // but to be sure log error
            return sprintf(
                'Date "%s" or "%s" is in incorrect format. Please use YYYY-MM-DD.',
                $startDate,
                $endDate
            );
        }

        $days = $start->diff($end)->days;
        if ($days <= $this::MAX_DAYS) {
            return null;
        }

        return sprintf('Number of days "%s" exceeds max days "%s".', $days, $this::MAX_DAYS);
    }
}
