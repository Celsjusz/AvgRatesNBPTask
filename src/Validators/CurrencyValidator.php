<?php

declare(strict_types=1);

namespace Luxdone\Validators;

use Luxdone\Enums\Currencies;

class CurrencyValidator implements CurrencyValidatorInterface
{
    protected array $supportedCurrencies = [
        Currencies::USD,
        Currencies::GBP,
        Currencies::EUR,
        Currencies::CHF,
    ];

    public function validate(?string $currency): ?string
    {
        if (in_array($currency, $this->supportedCurrencies)) {
            return null;
        }

        return sprintf('Currency "%s" is not available.', $currency);

    }
}
