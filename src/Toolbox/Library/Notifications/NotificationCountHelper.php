<?php
namespace Toolbox\Library\Notifications;

use Zend\View\Helper\AbstractHelper;


class NotificationCountHelper extends AbstractHelper {

    public function __construct(
        NotificationService $notificationService,
        NotificationsLogger $notificationLibrary
    )
    {
        $this->notificationService = $notificationService;
        $this->notificationLibrary = $notificationLibrary;
    }

    public function __invoke( $hours = null , $type_id = null )
    {

        $result =  $this->notificationService->getNotificationCount( $hours , $type_id );

        if ( null === $result)
        {
            return 0;
        }

        return $result;

    }
}