<?php
namespace Toolbox\Library\ReferrerValidator;

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
        $settings
    ) {
        $this->settings = $settings;
        $this->cookieService = new CookieService();
    }

    public function validate()
    {

        $referrer = (isset($_GET['referrer'])) ? $_GET['eferrer'] : false;
        $data = (isset($_GET['referrer_data'])) ? $_GET['referrer_data'] : null;

        /**
         * Update the variables
         */
        if ($referrer)
        {

            $referrerBundle = [
                'referrer' => $referrer,
                'data' => is_array($data) ? json_encode($data) : $data
            ];

            $referrerBundle = json_encode($referrerBundle);

            $params = [
                'name' => 'referrer',
                'value' => $referrerBundle
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

        if (is_null($cookie_data))
        {
            $referrer = $this->settings['affiliate_id'];
            $data = $this->settings['data'];
        } else {

            if (strlen($cookie_data['referrer']) != 32 OR empty($cookie_data['referrer']) OR $cookie_data['referrer'] == '' OR $cookie_data['referrer'] == null)
            {
                $referrer = isset($this->settings['affiliate_id']) ? $this->settings['affiliate_id'] : '';
                $data = isset($this->settings['data']) ? $this->settings['data'] : '';

            } else {
                $referrer = isset($cookie_data['referrer']) ? $cookie_data['referrer'] : '';
                $data =  isset($cookie_data['data']) ? $cookie_data['data'] : '';
            }

        }

        return ['referrer' => $referrer , 'data' => $data ];

    }


}

