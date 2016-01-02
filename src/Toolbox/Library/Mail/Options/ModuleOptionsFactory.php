<?php
namespace Toolbox\Library\Mail\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (isset($config['toolbox_mail'])) {
            return new ModuleOptions($config['toolbox_mail']);
        }

        return new ModuleOptions(array());
    }
}