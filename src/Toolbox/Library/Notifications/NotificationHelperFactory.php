<?php

namespace Toolbox\Library\Notifications;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class NotificationHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSl = $serviceLocator->getServiceLocator();

        return new NotificationHelper(
            $realSl->get(NotificationService::class),
            $realSl->get(NotificationsLogger::class)
        );
    }
}