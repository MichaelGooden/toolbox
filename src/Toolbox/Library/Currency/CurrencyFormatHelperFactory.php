<?php
namespace Toolbox\Library\Currency;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CurrencyFormatHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSl = $sl->getServiceLocator();

        return new CurrencyFormatHelper (
            $realSl->get(CurrencyMapper::class)
        );
    }
}