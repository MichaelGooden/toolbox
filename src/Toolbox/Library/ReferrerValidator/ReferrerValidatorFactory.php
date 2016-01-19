<?php
namespace Toolbox\Library\ReferrerValidator;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Toolbox\Library\Session\CookieService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ReferrerValidatorFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ReferrerValidator(
            $serviceLocator->get(ApplicationSettings::class),
            $serviceLocator->get(CookieService::class)
        );
    }
}