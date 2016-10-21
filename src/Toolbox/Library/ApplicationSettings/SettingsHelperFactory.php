<?php
namespace Toolbox\Library\ApplicationSettings;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class SettingsHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SettingsHelper (
            $container->get(ApplicationSettings::class)
        );
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        return $this($sl->getServiceLocator(), SettingsHelper::class);
    }
}
