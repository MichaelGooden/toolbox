<?php
namespace Toolbox\Controller;

/**
 * @author Brendan <b.nash at southeaster dot com>
 *
 * @Contributors:
 *
 */

use Toolbox\Library\Notifications\NotificationService;
use Toolbox\Library\Notifications\NotificationsLogger;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class ToolboxController extends AbstractActionController
{

    public function __construct(
        NotificationsLogger $notificationsLogger,
        NotificationService $notificationService
    ) {
        $this->notificationsLogger = $notificationsLogger;
        $this->notificationService = $notificationService;
    }

    public function notificationsAction()
    {
        $notifications = $this->notificationsLogger->getNotificationTypes();

        return new ViewModel(
            array( 'notifications' => $notifications )
        );
    }

    public function viewAction()
    {
        $type_id = (int) $this->params()->fromRoute('type_id', 0);
        $page_id = (int) $this->params()->fromRoute('page', 1);
        $count   = (int) $this->params()->fromRoute('count', 20);

        $data = $this->notificationService->getPaged( $page_id , $count , $type_id );

        return new ViewModel(
            array( 'paginator' => $data )
        );

    }


}