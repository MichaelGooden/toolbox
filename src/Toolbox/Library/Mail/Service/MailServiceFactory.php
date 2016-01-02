<?php
namespace Toolbox\Library\Mail\Service;

use Toolbox\Library\Mail\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MailService(
            $serviceLocator->get('viewrenderer'),
            $serviceLocator->get(ModuleOptions::class)
        );
    }
}