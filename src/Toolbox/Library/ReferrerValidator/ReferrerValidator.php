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

    public function validate()
    {
        $cookieService = new CookieService();

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

            $cookieService->setCookie($params);

        }

        return;

    }


}

