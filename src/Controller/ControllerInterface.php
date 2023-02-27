<?php

declare(strict_types=1);

namespace Luxdone\Controller;

interface ControllerInterface
{
    public function process(array $request): array;
}
