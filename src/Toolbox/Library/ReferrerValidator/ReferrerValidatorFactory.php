<?php
namespace Toolbox\Library\ReferrerValidator;

use Interop\Container\ContainerInterface;
use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Toolbox\Library\Session\CookieService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ReferrerValidatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ReferrerValidator(
            $container->get(ApplicationSettings::class),
            $container->get(CookieService::class)
        );
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, ReferrerValidator::class);
    }
}
