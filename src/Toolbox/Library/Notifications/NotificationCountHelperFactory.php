<?php

namespace Toolbox\Library\Notifications;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class NotificationCountHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSl = $serviceLocator->getServiceLocator();

        return new NotificationCountHelper(
            $realSl->get(NotificationService::class),
            $realSl->get(NotificationsLogger::class)
        );
    }
}