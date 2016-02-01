<?php

namespace Toolbox\Library\Session;

use Zend\View\Helper\AbstractHelper;


class CookieHelper extends AbstractHelper {

    public function __construct(
        CookieService $cookieService
    )
    {
        $this->cookieService = $cookieService;
    }

    public function __invoke( $value = 'referrer' , $method = 'getCookie' )
    {

        $cookie = $this->cookieService->$method($value);

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