<?php
namespace Toolbox\Library\Currency;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CurrencyFormatHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CurrencyFormatHelper(
            $container->get(CurrencyMapper::class)
        );
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        return $this($sl->getServiceLocator(), CurrencyFormatHelper::class);
    }
}
