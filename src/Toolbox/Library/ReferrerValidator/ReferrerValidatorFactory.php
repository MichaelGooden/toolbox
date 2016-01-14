<?php
namespace Toolbox\Library\ReferrerValidator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReferrerValidatorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $settings = $serviceLocator->get('Config')['toolbox-settings']['default_affiliate'];

        return new ReferrerValidator(
            $settings
        );
    }
}