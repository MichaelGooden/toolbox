<?php
namespace Toolbox\Library\Session;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CookieHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CookieHelper (
            $container->get(CookieService::class)
        );
    }

    public function createService(ServiceLocatorInterface $sl)
    {
        return $this($sl->getServiceLocator(), CookieHelper::class);
    }
}
