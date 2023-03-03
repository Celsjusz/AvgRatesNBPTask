<?php

declare(strict_types=1);

namespace AvgRates;

use AvgRates\Calculators\AverageBidCalculator;
use AvgRates\Calculators\AverageBidCalculatorInterface;
use AvgRates\Connectors\CurlConnector;
use AvgRates\Connectors\CurlConnectorInterface;
use AvgRates\Controller\ControllerInterface;
use AvgRates\Controller\NBPController;
use AvgRates\Service\NBPService;
use AvgRates\Service\ServiceInterface;
use AvgRates\Validators\CurrencyValidator;
use AvgRates\Validators\CurrencyValidatorInterface;
use AvgRates\Validators\DateRangeValidatorInterface;
use AvgRates\Validators\DateValidator;
use AvgRates\Validators\DateValidatorInterface;
use AvgRates\Validators\NBPDateRangeValidator;
use AvgRates\Validators\NBPValidator;
use AvgRates\Validators\RequestTypeValidator;
use AvgRates\Validators\RequestTypeValidatorInterface;
use AvgRates\Validators\ValidatorInterface;

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
