<?php

declare(strict_types=1);

namespace Luxdone\Calculators;

interface AverageBidCalculatorInterface
{
    public function calculate(array $data): float;
}
