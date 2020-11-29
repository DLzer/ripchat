<?php

use App\Factory\LoggerFactory;
use App\Factory\RedisFactory;
use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    // Settings
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    // //Database connection
    // Connection::class => function (ContainerInterface $container) {
    //     $factory = new ConnectionFactory(new IlluminateContainer());

    //     $connection = $factory->make($container->get(Configuration::class)->getArray('db'));

    //     // Disable the query log to prevent memory issues
    //     $connection->disableQueryLog();

    //     return $connection;
    // },

    // //Initialize PDO
    // PDO::class => function (ContainerInterface $container) {
    //     return $container->get(Connection::class)->getPdo();
    // },

    // Logging Interface -- Monolog
    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get(Configuration::class)->getArray('logger'));
    },

    // Redis Factory
    RedisFactory::class => function (ContainerInterface $container) {
        return new RedisFactory($container->get(Configuration::class)->getArray('redis'), $container->get(LoggerFactory::class));
    },

    // DI Container to App
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // We'll only set this if we plan on running the app in a sub-directory
        // The public directory must not be part of the base path
        //$app->setBasePath('/slim4app');

        return $app;
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get(Configuration::class)->getArray('error_handler_middleware');

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },


];