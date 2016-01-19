<?php
namespace Toolbox\Library\Currency;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CurrencyOptionsHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSL = $serviceLocator->getServiceLocator();

        return new CurrencyOptionsHelper(
            $realSL->get(CurrencyMapper::class)
        );
    }
}