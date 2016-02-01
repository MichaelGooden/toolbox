<?php

namespace Toolbox\Library\Session;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CookieHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSl = $sl->getServiceLocator();

        return new CookieHelper (
            $realSl->get(CookieService::class)
        );
    }
}