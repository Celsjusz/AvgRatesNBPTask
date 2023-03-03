<?php

declare(strict_types=1);

namespace AvgRates\Calculators;

interface AverageBidCalculatorInterface
{
    public function calculate(array $data): float;
}
