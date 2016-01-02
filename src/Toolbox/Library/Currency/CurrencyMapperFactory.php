<?php
namespace Toolbox\Library\Currency;

use Toolbox\Library\ExRates\ExchangeRateService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencyMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $default_currency = $serviceLocator->get('Config')['toolbox-settings']['default_currency'];

        return new CurrencyMapper(
            $serviceLocator->get(ExchangeRateService::class),
            $default_currency
        );
    }
}