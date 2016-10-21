<?php
namespace Toolbox\Library\ApplicationSettings;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationSettingsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $settings = $container->get('Config');

        if (!isset($settings['toolbox-settings']))
        {
            throw new \Exception("Please set the toolbox settings...");
        }

        return new ApplicationSettings(
            $settings['toolbox-settings']
        );
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|ApplicationSettings
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, ApplicationSettings::class);
    }
}
