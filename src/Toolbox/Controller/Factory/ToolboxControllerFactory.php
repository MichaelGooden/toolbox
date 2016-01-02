<?php
namespace Toolbox\Controller\Factory;

/**
 * @author Brendan <b.nash at southeaster dot com>
 *
 * @Contributors:
 *
 */

use Toolbox\Controller\ToolboxController;
use Toolbox\Library\Notifications\NotificationService;
use Toolbox\Library\Notifications\NotificationsLogger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ToolboxControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSL =  $serviceLocator->getServiceLocator();

        return new ToolboxController(
            $realSL->get(NotificationsLogger::class),
            $realSL->get(NotificationService::class)
        );
    }
}