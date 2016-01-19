<?php
namespace Toolbox\Library\Session;

use Zend\View\Helper\AbstractHelper;


class SessionHelper extends AbstractHelper {

    public function __invoke( $value , $method = 'getDataValue' )
    {

        $session = new SessionService();

        return $session->$method($value);


    }
}