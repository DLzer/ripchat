RIPCHAT
==========

RIPCHAT is meant to be a safe and temporary message solution. Channels are created instantly with a unique identifier that can be shared between parties.
The liftime of a channel is 60 seconds. However, for every message sent the life-span of the channel is extended another 60 seconds. 
If a user wishes they can delete the channel on demand, destroying it instantly and permanently.


Configuration
-------------

The directory for all configuration files is: `config/`
In this file are the core files for running the application.
- `settings.php`: Manages all core settings and environment variables for the application
- `bootstrap.php`: Loads the Container, Routes, Middleware and Settings.
- `middleware.php`: Contains middleware for the application.
- `routes.php`: Contains defined routes for the application.
- `container.php`: Houses the ContainerInterface utilizing PHP-DI for injection into the application.

FrontController
---------------

The front controller is just the `index.php` file and entry point to the application. This handles all requests through the application by channeling requests through a single handler object.

Container
---------

Traditionally the style of fetching dependencies was to inject the whole container into your class which is considered an **anti-pattern**. We switch up the method in this application by using modern tools like [PHP-DI](http://php-di.org/).

The DI used in this application is housed in a **Depedency Injection Container** ( DIC ). The method we use in this application is [composition over inheritance](https://en.wikipedia.org/wiki/Composition_over_inheritance) and (constructor) DI.

Domain
------

The domain in this application houses the complex **business logic**.
Instead of putting together business logic into massive fat "Models", they are separated into specialized *Services* aka an **Application Service**

Each service can have multiple clients, e.g Action (request), CLI (console), Data (logic), Unit Testing (phpunit). This way each service manages only one responsibility and not more by separating data from behavior.

Redis
--------

In this project REDIS is used as a quick-access key-value data store. All access to REDIS can be managed through the redis factory located in `src/factory`.
The factory is part of the Dependency Injection Container and can be passed by reference directly into the class constructor of whatever you're building like so:
````php
<?php

namespace App\Domain\MyClass\Service\MyClassService;

use App\Factory\RedisFactory;

final class MyClass
{
    private $redis;

    public function __construct(RedisFactory $redis)
    {
        $this->redis = $redis;
    }

    public function storeSomething(): void
    {
        $this->redis->set('Key', 'Value');
    }

    public function getSomething(): array
    {
        $result = $this->redis->get('key');
        return $result // ['Key' => 'Value']
    }
}
````

Deployment
----------

Deployment is best served through a **build pipeline** however if manual deployment is necessary it's as simple as running:
````shell
composer install --no-dev --optimize-autoloader
````
This will remove dev-dependencies as well as optimize the composer autoloader for better performance.

For security reasons it's also best practice to turn of output of error details:
````php
$settings['error_handler_middleware'] = [
    'display_error_details' => false,
];
````

Endpoints
----------

The current endpoints in use are: 
- `POST`:`/channel/create` - `{"channel_name": "<name>"}`
- `POST`:`/channel/get` - `{"channel_hash": "<channelHash>}`
- `POST`:`/channel/delete` - `{"channel_hash": "<channelHash>}`
- `POST`:`/message/send` - `{"channel_hash": "<channelHash>", "message_body": "<message_body>"}`

Testing
----------

To avoid any global dependency issue between developer, all testing should be completed
within the project using the composer sciprt:
````shell
composer test
````
The tests should be built and ran before making a push to the repository. A github action for CI
is in place that will run all tests on trigger-push.

Testing configuration is handled by the `phpunit.xml` file in the `test/` directory.
