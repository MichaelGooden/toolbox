<?php
namespace Toolbox\Library\Countries;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CountryNameHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CountryNameHelper($container->get(CountriesService::class));
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        return $this($sl->getServiceLocator(), CountryNameHelper::class);
    }
}
