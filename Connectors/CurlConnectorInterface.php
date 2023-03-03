<?php

declare(strict_types=1);

namespace AvgRates\Connectors;

interface CurlConnectorInterface
{
    public function getData(string $url, array $headers = ['Accept: application/json']): bool|string|null;
}
