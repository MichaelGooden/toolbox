<?php
/*  LotteryNameHelper
 *  This helper is used to return draw numbers with error checking
 *  used in view/draw/index.phtml
 *
 */
namespace Toolbox\Library\ApplicationSettings;

use Zend\View\Helper\AbstractHelper;


class SettingsHelper extends AbstractHelper {

    protected $countriesService;

    public function __construct(
        ApplicationSettings $appSettings
    )
    {
        $this->settings = $appSettings;
    }

    public function __invoke( $setting )
    {
        return $this->settings->getSettings($setting);

    }
}