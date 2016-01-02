<?php

namespace Toolbox\Library\ApplicationSettings;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class SettingsHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSl = $sl->getServiceLocator();

        return new SettingsHelper (
            $realSl->get(ApplicationSettings::class)
        );
    }
}