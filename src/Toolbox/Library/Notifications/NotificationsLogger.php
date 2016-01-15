<?php
namespace Toolbox\Library\Notifications;

use Toolbox\Entity\Notifications;
use Zend\EventManager\EventManagerInterface;

class NotificationsLogger
{
    const SYSTEM_MESSAGE = 'toolbox.library.notifications';

    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected  $eventManager;

    /**
     * @var \Application\Service\NotificationService
     */
    protected  $notificationsService;

    /**
     * @param NotificationService $notificationsService
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        NotificationService $notificationsService,
        EventManagerInterface $eventManager
    ) {
        $this->notificationsService = $notificationsService;
        $this->eventManager = $eventManager;
    }

    /**
     * This returns an array of notification types
     *
     * @return array
     */
    public function getNotificationTypes()
    {
        return [
            1 => 'General',
            2 => 'Registration',
            3 => 'Password Reset',
            4 => 'Login Error',
            5 => 'Deposit Error',
            6 => 'Error',
            7 => 'Api Problems',
            8 => 'Testing',
            9 => 'Payment Error',
            10 => 'Game Transfer Error',
            11 => 'Transfer Error',
            12 => 'Email error',
            13 => 'Jackpot Scraper Error',
            14 => 'tests'
        ];

    }

    /**
     * Returns the type name used in the GameTypeHelper function
     * @param $id
     * @return mixed
     */
    public function getNotificationName($id)
    {
        $names =  $this->getNotificationTypes();
        return $names[$id];
    }

    /**
     * @param $type_id
     * @return bool
     */
    private function checkType($type_id)
    {
        $types = $this->getNotificationTypes();

        if (isset($types[$type_id]))
        {
            return true;
        }

        return false;

    }

    /**
     * This function adds a notification to the cloud_notifications table
     * @param $type_id
     * @param $message
     * @param bool $send_email
     * @return bool
     */
    public function addNotification( $type_id , $message , $send_email = false )
    {
        if ($send_email)
        {
            $this->sendEmail($message);
        }

        if ($this->checkType($type_id))
        {
            $notification = new Notifications();
            $notification->setType($type_id);
            $notification->setMessage($message);

            $result = $this->notificationsService->update($notification);

            if ($result)
            {
                return true;
            }


            return false;
        }

        return false;

    }

    private function sendEmail($message)
    {
        $this->eventManager->trigger(
            self::SYSTEM_MESSAGE,
            $_POST,
            [
                'message' => $message
            ]
        );
    }

}

