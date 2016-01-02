<?php

namespace Toolbox\Library\Session;

use Zend\View\Helper\AbstractHelper;


class CookieHelper extends AbstractHelper {

    public function __invoke( $value = 'referrer' , $method = 'getCookie' )
    {
        $cookieService = new CookieService();

        $cookie = $cookieService->$method($value);

        /**
         * Test and extract the cookie
         */
        if (is_object(json_decode($cookie)))
        {
            $cookie = json_decode($cookie,true);
        }

        if (is_object(json_decode($cookie['data'])))
        {
            $cookie['data'] = json_decode($cookie['data'] , true);
        }

        return $cookie;

    }
}