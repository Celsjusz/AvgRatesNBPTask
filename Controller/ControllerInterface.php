<?php

declare(strict_types=1);

namespace AvgRates\Controller;

interface ControllerInterface
{
    public function process(array $request): array;
}
