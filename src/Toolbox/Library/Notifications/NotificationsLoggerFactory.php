<?php
namespace Toolbox\Library\Notifications;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationsLoggerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new NotificationsLogger(
            $serviceLocator->get(NotificationService::class),
            $serviceLocator->get('application')->getEventManager()
        );
    }
}