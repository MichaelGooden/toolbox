<?php
namespace Toolbox\Library\Session;
use Toolbox\Library\ApplicationSettings\ApplicationSettings;

/**
 * Use this service to set persistent cookies on a users machine
 * Class CookieService
 * @package Application\Library\Session
 */

class CookieService
{
    /**
     * @param ApplicationSettings $applicationSettings
     */
    public function __construct(
        ApplicationSettings $applicationSettings
    )
    {
        $this->applicationSettings = $applicationSettings;
    }


    /**
     * Create a new cookie
     * @param $params
     */
    public function setCookie($params)
    {

        $domain = $this->applicationSettings->getSettings('cookie_domain');

        $name = (isset($params['name'])) ? $params['name'] : 'referrer';
        $value = (isset($params['value'])) ? $params['value'] : '';
        $expire = (isset($params['expire'])) ? time() + $params['expire'] : time() +  365 * 60 * 60 * 24;
        $path = (isset($params['path'])) ? $params['path'] : '';
        $domain = (isset($params['domain'])) ? $params['domain'] : $domain;
        $secure = (isset($params['secure'])) ? $params['secure'] : 0;
        $httponly = (isset($params['httponly'])) ? $params['httponly'] : 0;

        /**
         * Test whether the cookie exists before updating
         */
        if (!$this->exists($name))
        {
            setcookie(
                $name,
                $value,
                $expire,
                $path,
                $domain,
                $secure,
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

    /**
     * Returns a cookie as an array
     * @param string $name
     * @return mixed|null
     */
    function decodeCookie($name = 'referrer')
    {
        $cookie = $this->getCookie($name);

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