<?php
namespace Toolbox\Library\Currency;

use Interop\Container\ContainerInterface;
use Toolbox\Library\ExRates\ExchangeRateService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencyMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $default_currency = $container->get('Config')['toolbox-settings']['default_currency'];

        return new CurrencyMapper(
            $container->get(ExchangeRateService::class),
            $default_currency
        );
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, CurrencyMapper::class);
    }
}
