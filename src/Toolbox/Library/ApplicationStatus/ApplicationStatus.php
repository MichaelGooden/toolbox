<?php
namespace Toolbox\Library\ApplicationStatus;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Checks to see if we are in update mode,
 * Returns true or false
 * Class ReferrerValidator
 * @package Application\Library\ReferrerValidator
 */
class ApplicationStatus extends AbstractActionController
{

    public function __construct(
        ApplicationSettings $applicationSettings
    ) {
        $this->applicationSettings = $applicationSettings;
    }

    public function check()
    {

        $admin_mode = (isset($_GET['admin_mode'])) ? true : false;

        /**
         * If we are in admin mode, then we want to see the web page
         */
        if ($admin_mode)
        {
            return ['status' => true , 'message' => ''];
        }

        /**
         * Check the admin mode variables in the global config
         */
        $update_mode = $this->applicationSettings->getSettings('application_status');

        return ['status' => $update_mode['is_live'] , 'message' => $update_mode['message'] ];

    }

}