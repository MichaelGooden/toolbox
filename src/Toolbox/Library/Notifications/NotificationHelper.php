<?php
namespace Toolbox\Library\Notifications;

use Zend\View\Helper\AbstractHelper;


class NotificationHelper extends AbstractHelper {

    public function __construct(
        NotificationService $notificationService,
        NotificationsLogger $notificationLibrary
    )
    {
        $this->notificationService = $notificationService;
        $this->notificationLibrary = $notificationLibrary;
    }

    public function __invoke( $hours = null)
    {
        //Set the default hours
        if ( null === $hours )
        {
            $hours = 24;
        }

        //Grab the list of notifications in the last n hours
        $notifications = $this->notificationService->getLastHours($hours);

        //Set up the notifications array
        $notificationArray = [];
        $notificationArray['output'] = [];

        //Store the total notifications
        $notificationArray['total'] = count($notifications);

        //Put the data into an array for clarity
        foreach ($notifications AS $notification)
        {
            $notificationArray['data'][$notification['type']][] = $notification['message'];
        }

        //Get the notification types from the library
        $types = $this->notificationLibrary->getNotificationTypes();

        //Loop through the types and add a message to the array for use in the view
        foreach ($types AS $type_key => $type)
        {
            if (isset($notificationArray['data'][$type_key]))
            {
                //Store the notifications as an array for the given type
                $notesArray = $notificationArray['data'][$type_key];
                $noteCount = count($notesArray);
                $message = "events";

                //We need the singular of the word
                if ($noteCount === 1)
                {
                   $message = "event";
                }

                $notificationArray['output'][] = ['message' => $type.": ".$noteCount." ".$message , 'type_id' => $type_key];

            }

        }

        return $notificationArray;

    }
}