<?php
namespace Toolbox\Library\Notifications;

use Interop\Container\ContainerInterface;
use Toolbox\Entity\Notifications;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $objectManager = $container->get('Doctrine\ORM\EntityManager');

        return new NotificationService(
            $objectManager,
            $objectManager->getRepository(Notifications::class)
        );
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, NotificationService::class);
    }
}
