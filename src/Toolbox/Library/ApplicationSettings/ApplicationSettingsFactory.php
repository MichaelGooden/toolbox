<?php
namespace Toolbox\Library\ApplicationSettings;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationSettingsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|ApplicationSettings
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $settings = $serviceLocator->get('Config');

        if (isset($settings['toolbox-settings']))
        {
            return new ApplicationSettings(
                $settings['toolbox-settings']
            );
        }

        throw new \Exception("Please set the toolbox settings...");


    }
}