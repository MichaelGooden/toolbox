<?php
namespace Toolbox\Library\ExRates;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateExchangeRateFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        return new UpdateExchangeRate(
            $serviceLocator->get(ExchangeRateService::class)
        );
    }
}