<?php
namespace Toolbox\Library\Session;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CookieServiceFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        return new CookieService(
            $serviceLocator->get(ApplicationSettings::class)
        );
    }
}