<?php
namespace Toolbox\Controller;

/**
 * @author Brendan <b.nash at southeaster dot com>
 *
 * @Contributors:
 *
 */

use Zend\Crypt\Password\Bcrypt;
use Zend\Form\FormInterface;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class ToolboxController extends AbstractActionController
{

    public function __construct(

    ) {
    }

    /**
     * View the clients
     * @return Response
     */
    public function overviewAction()
    {

        return new ViewModel([]);
    }


}