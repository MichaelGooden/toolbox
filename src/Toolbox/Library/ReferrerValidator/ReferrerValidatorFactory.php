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
        $realSl = $serviceLocator->getServiceLocator();

        return new ReferrerValidator(
            $realSl->get(ApplicationSettings::class),
            $realSl->get(CookieService::class)
        );
    }
}