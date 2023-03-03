<?php

declare(strict_types=1);

namespace AvgRates\Connectors;

class CurlConnector implements CurlConnectorInterface
{
    public function getData(string $url, array $headers = ['Accept: application/json']): bool|string|null
    {
        $curlHandler = curl_init();

        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curlHandler);

        curl_close($curlHandler);
        if (curl_errno($curlHandler)) {
            //log error
            return null;
        }

        return $response;
    }
}
