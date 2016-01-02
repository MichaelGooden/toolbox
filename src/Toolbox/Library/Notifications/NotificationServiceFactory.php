<?php
namespace Toolbox\Library\Notifications;

use Toolbox\Entity\Notifications;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        return new NotificationService(
            $objectManager,
            $objectManager->getRepository(Notifications::class)
        );
    }
}