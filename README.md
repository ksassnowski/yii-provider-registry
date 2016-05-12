# Yii Provider Registry

Provides a Laravel-inspired way to register services into a Yii application.

## Installation

Require the library via Composer.

```bash
composer require sassnowski/yii-provider-registry
```

## Setup

Change the last few lines in your `web/index.php` to this:

```php
$app = new yii\web\Application($config)

(new \Sassnowski\Yii2\ProviderRegistry\ProviderRegistry(\Yii::$container))->bootstrap();

$app->run();
```


Create a `bootstrap` folder in your application root and put a `services.php`
file into it. This file should simply return an array of **Bootstrapper**
classes.

```php
<?php

return [
    \Acme\Providers\MyProvider::class,
    \Acme\Providers\AnotherProvider::class,
    \Acme\Providers\Mailing\MailProvider::class,
];
```

These classes should implement a `bootstrap` method. This method will be
called during the bootstrapping process and receives the applications DI
Container as its only parameter. Inside this method you can then register
classes into the Yii DI Container.

```php
<?php

namespace Acme\Providers;

use yii\di\Container;

class MyProvider
{
    public function bootstrap(Container $container)
    {
        $container->set(
            \Acme\Services\MySickServiceInterface::class,
            \Acme\Services\MySickServiceImplementation::class
        );
    }
}
```

That's it! Now you can use the service anywhere inside the application either
by explicitly resolving it out of the container via `get` or by type hinting it
in the constructor. Refer to the (Yii Documentation)[http://www.yiiframework.com/doc-2.0/guide-concept-di-container.html] for 
the full list of possibilities!

## License

MIT
