<?php

declare(strict_types=1);

namespace Luxdone\Calculators;

class AverageBidCalculator implements AverageBidCalculatorInterface
{
    public function calculate(array $data): float
    {
        $bidSum = 0.0;
        $count = 0;

        foreach ($data as $rate) {
            $bidSum += $rate->bid;
            $count++;
        }

        return round($bidSum / $count, 4);
    }
}
