<?php
namespace Toolbox\Library\ApplicationSettings;

class ApplicationSettings
{

    /**
     * @param $settings
     */
    public function __construct(
        $settings
    ) {
        $this->settings = $settings;
    }

    /**
     * @param $settings
     * @return mixed
     */
    public function getSettings($settings)
    {
        if ( ! isset($this->settings[$settings]))
        {
            return false;
        }

        return $this->settings[$settings];
    }

    /**
     * Returns all the settings
     * @return mixed
     */
    public function getAllSettings()
    {
        return $this->settings;
    }

}

