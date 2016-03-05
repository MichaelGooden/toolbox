<?php
namespace Toolbox\Library\ReferrerValidator;

use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Toolbox\Library\Session\CookieService;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Pulls the data out of the bundle
 * Class ReferrerValidator
 * @package Application\Library\ReferrerValidator
 */
class ReferrerValidator extends AbstractActionController
{

    public function __construct(
        ApplicationSettings $applicationSettings,
        CookieService $cookierSerice
    ) {
        $this->cookieService = $cookierSerice;
        $this->applicationSettings = $applicationSettings;
    }

    public function validate()
    {

        $referrer = (isset($_GET['referrer'])) ? $_GET['referrer'] : false;
        $data = (isset($_GET['referrer_data'])) ? $_GET['referrer_data'] : null;

        /**
         * Update the variables
         */
        if ($referrer)
        {

            $referrerBundle = [
                'referrer' => $referrer,
                'data' => is_array($data) ? json_encode($data) : $data,
            ];

            $referrerBundle = json_encode($referrerBundle);

            $params = [
                'name'  => 'referrer',
                'value' => $referrerBundle,
                'path'  => '/',
            ];

            $this->cookieService->setCookie($params);

        }

        return;

    }

    /**
     * Get the stored referrer information,
     */
    public function getReferrerInformation()
    {
        $cookie_data = $this->cookieService->decodeCookie();
        $default_affiliate = $this->applicationSettings->getSettings('default_affiliate');

        if (is_null($cookie_data))
        {
            $referrer = $default_affiliate['affiliate_id'];
            $data = $default_affiliate['affiliate_data'];
        } else {

            if (strlen($cookie_data['referrer']) != 32 OR empty($cookie_data['referrer']) OR $cookie_data['referrer'] == '' OR $cookie_data['referrer'] == null)
            {
                $referrer = isset($default_affiliate['affiliate_id']) ? $default_affiliate['affiliate_id'] : '';
                $data = isset($default_affiliate['affiliate_data']) ? $default_affiliate['affiliate_data'] : '';

            } else {
                $referrer = isset($cookie_data['referrer']) ? $cookie_data['referrer'] : '';
                $data =  isset($cookie_data['data']) ? $cookie_data['data'] : '';
            }

        }

        return ['referrer' => $referrer , 'data' => $data ];

    }


}

