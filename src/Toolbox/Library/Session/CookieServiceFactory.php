<?php
namespace Toolbox\Library\Session;

use Interop\Container\ContainerInterface;
use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CookieServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CookieService(
            $container->get(ApplicationSettings::class)
        );
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, CookieService::class);
    }
}
