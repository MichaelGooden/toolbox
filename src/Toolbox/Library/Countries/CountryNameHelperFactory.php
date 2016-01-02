<?php
namespace Toolbox\Library\Countries;

use Application\View\Helper\CountryNameHelper;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CountryNameHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSl = $sl->getServiceLocator();

        return new CountryNameHelper (
            $realSl->get(CountriesService::class)
        );
    }
}