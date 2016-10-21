<?php
namespace Toolbox\Library\Currency;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CurrencyOptionsHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CurrencyOptionsHelper(
            $container->get(CurrencyMapper::class)
        );
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), CurrencyOptionsHelper::class);
    }
}
