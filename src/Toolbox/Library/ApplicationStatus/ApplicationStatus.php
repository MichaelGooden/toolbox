<?php
namespace Toolbox\Library\ApplicationStatus;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;

/**
 * Checks to see if we are in update mode,
 * Returns true = the site is live, or false, the site is closed
 * Class ReferrerValidator
 * @package Application\Library\ReferrerValidator
 */
class ApplicationStatus
{

    public function __construct(
        ApplicationSettings $applicationSettings
    ) {
        $this->applicationSettings = $applicationSettings;
    }

    /**
     * @return array|bool
     */
    public function check()
    {
        /**
         * Check the admin mode variables in the global config
         */
        $update_mode = $this->applicationSettings->getSettings('application_status');

        if ( !isset($update_mode['is_live']) OR !isset($update_mode['message']))
        {
            return true;
        }

        return ['status' => $update_mode['is_live'] , 'message' => $update_mode['message'] ];

    }


}