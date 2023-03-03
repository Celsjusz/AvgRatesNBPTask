<?php

declare(strict_types=1);

namespace AvgRates\Service;

interface ServiceInterface
{
    public function getData(array $data): ?array;
}
