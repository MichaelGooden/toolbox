<?php
namespace Toolbox\Controller\Factory;

/**
 * @author Brendan <b.nash at southeaster dot com>
 *
 * @Contributors:
 *
 */

use Interop\Container\ContainerInterface;
use Toolbox\Controller\ToolboxController;
use Toolbox\Library\Notifications\NotificationService;
use Toolbox\Library\Notifications\NotificationsLogger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ToolboxControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ToolboxController(
            $container->get(NotificationsLogger::class),
            $container->get(NotificationService::class)
        );
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), ToolboxController::class);
    }
}
