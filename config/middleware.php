<?php

use Selective\Config\Configuration;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add routing middleware
    $app->addRoutingMiddleware();

    // Add Error Middleware
    $app->add(ErrorMiddleware::class);
};