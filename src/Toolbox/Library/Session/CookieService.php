<?php
namespace Toolbox\Library\Session;

/**
 * Use this service to set persistent cookies on a users machine
 * Class CookieService
 * @package Application\Library\Session
 */

class CookieService
{

    /**
     * Create a new cookie
     * @param $params
     */
    public function setCookie($params)
    {
        $name = (isset($params['name'])) ? $params['name'] : 'referrer';
        $value = (isset($params['value'])) ? $params['value'] : '';
        $expire = (isset($params['expire'])) ? time() + $params['expire'] : time() +  365 * 60 * 60 * 24;
        $path = (isset($params['path'])) ? $params['path'] : '';
        $domain = (isset($params['domain'])) ? $params['domain'] : 'gamblingtec.com';
        $secure = (isset($params['secure'])) ? $params['secure'] : 0;
        $httponly = (isset($params['httponly'])) ? $params['httponly'] : 1;

        /**
         * Test whether the cookie exists before updating
         */
        if (!$this->exists($name))
        {
            setcookie(
                $name,
                $value,
                $expire ,
                $path ,
                $domain ,
                $secure ,
                $httponly
            );
        }

    }

    /**
     * Get a cookie based on a given key
     * @param string $name
     * @return null
     */
    public function getCookie($name = 'referrer')
    {
        return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : null;
    }

    /**
     * Returns whether a cookie exists or not
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return ( $this->getCookie($name) ) ? true : false;
    }

    /**
     * Remove a cookie
     * @param $name
     */
    function deleteCookie($name)
    {
        if ($this->exists($name))
        {
            setcookie($name, "", time()-(60*60*24) );
        }
    }

}