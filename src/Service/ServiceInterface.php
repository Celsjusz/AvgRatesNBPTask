<?php

declare(strict_types=1);

namespace Luxdone\Service;

interface ServiceInterface
{
    public function getData(array $data): ?array;
}
