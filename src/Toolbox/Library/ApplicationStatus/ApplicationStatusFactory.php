<?php
namespace Toolbox\Library\ApplicationStatus;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ApplicationStatusFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSl = $serviceLocator->getServiceLocator();

        return new ApplicationStatus(
            $realSl->get(ApplicationSettings::class)
        );
    }
}