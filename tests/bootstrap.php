<?php

require_once __DIR__ . '/../src/vendor/autoload.php';

Testbench\Bootstrap::setup(__DIR__ . '/_temp', function (Nette\Configurator $configurator) {
    $configurator->createRobotLoader()->addDirectory([
        __DIR__ . '/../src/app',
    ])->register();

    $configurator->addParameters([
        'appDir' => __DIR__ . '/../src/app',
        'testsDir' => __DIR__,
    ]);

    $configurator->addConfig(__DIR__ . '/../src/app/config/config.neon');
    $configurator->addConfig(__DIR__ . '/test.neon');
});
