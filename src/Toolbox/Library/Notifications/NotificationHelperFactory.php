<?php
namespace Toolbox\Library\Notifications;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class NotificationHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new NotificationHelper(
            $container->get(NotificationService::class),
            $container->get(NotificationsLogger::class)
        );
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), NotificationHelper::class);
    }
}
