<?php

namespace Sassnowski\Yii2\ProviderRegistry;

use Yii;
use RuntimeException;
use yii\di\Container;

class ProviderRegistry
{
    /**
     * @var array
     */
    protected $bootstrappers = [];

    /**
     * @var Container
     */
    protected $container;

    /**
     * ProviderRegistry constructor.
     *
     * @param Container $container The applications DI Container.
     */
    public function __construct(Container $container)
    {
        $configPath = Yii::getAlias('@app/bootstrap/services.php');

        if (! is_file($configPath))
        {
            throw new RuntimeException('Unable to load bootstrap/services.php. Make sure the file exists.');
        }
            
        $this->bootstrappers = require($configPath);

        $this->container = $container;
    }

    /**
     * Registers all bootstrappers into the application.
     * 
     * @return void
     */
    public function bootstrap()
    {
        foreach ($this->bootstrappers as $bootstrapper)
        {
            (new $bootstrapper)->bootstrap($this->container);
        }
    }
}
