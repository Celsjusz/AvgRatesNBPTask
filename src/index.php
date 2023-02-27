<?php

declare(strict_types=1);

namespace Luxdone;

use Luxdone\Calculators\AverageBidCalculator;
use Luxdone\Calculators\AverageBidCalculatorInterface;
use Luxdone\Connectors\CurlConnector;
use Luxdone\Connectors\CurlConnectorInterface;
use Luxdone\Controller\ControllerInterface;
use Luxdone\Controller\NBPController;
use Luxdone\Service\NBPService;
use Luxdone\Service\ServiceInterface;
use Luxdone\Validators\CurrencyValidator;
use Luxdone\Validators\CurrencyValidatorInterface;
use Luxdone\Validators\DateRangeValidatorInterface;
use Luxdone\Validators\DateValidator;
use Luxdone\Validators\DateValidatorInterface;
use Luxdone\Validators\NBPDateRangeValidator;
use Luxdone\Validators\NBPValidator;
use Luxdone\Validators\RequestTypeValidator;
use Luxdone\Validators\RequestTypeValidatorInterface;
use Luxdone\Validators\ValidatorInterface;

require_once('../vendor/autoload.php');

$builder = new \DI\ContainerBuilder();

//add definitions
$builder->addDefinitions([
    AverageBidCalculatorInterface::class => \DI\autowire(AverageBidCalculator::class),
    CurlConnectorInterface::class => \DI\autowire(CurlConnector::class),
    ServiceInterface::class => \DI\autowire(NBPService::class),
    CurrencyValidatorInterface::class => \DI\autowire(CurrencyValidator::class),
    DateRangeValidatorInterface::class => \DI\autowire(NBPDateRangeValidator::class),
    DateValidatorInterface::class => \DI\autowire(DateValidator::class),
    ValidatorInterface::class => \DI\autowire(NBPValidator::class),
    ControllerInterface::class => \DI\autowire(NBPController::class),
    RequestTypeValidatorInterface::class => \DI\autowire(RequestTypeValidator::class),
]);

try {
    $container = $builder->build();

    /** @var NBPController $NBPController */
    $NBPController = $container->get(NBPController::class);
} catch (\Exception $e) {
    die('Could not create DI container.');
}

$uri = $_SERVER['REQUEST_URI'];

// don't preserve keys
$givenData = array_values(array_filter(explode('/', $uri)));

$result = $NBPController->process(
    [
        'currency' => $givenData[0] ?? null,
        'start_date' => $givenData[1] ?? null,
        'end_date' => $givenData[2] ?? null,
    ]
);

header('Content-Type: application/json; charset=utf-8');
if ($result['status']) {
    echo json_encode($result['data']);
} else {
    echo json_encode(['errors' => $result['data']['message']]);
}
