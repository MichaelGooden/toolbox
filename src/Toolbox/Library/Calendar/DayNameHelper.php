<?php
/*  LotteryNameHelper
 *  This helper is used to return draw numbers with error checking
 *  used in view/draw/index.phtml
 *
 */
namespace Toolbox\Library\Calendar;

use Zend\View\Helper\AbstractHelper;


class DayNameHelper extends AbstractHelper {

    public function __invoke($day_id)
    {
        $calendar = new Calendar();

        return $calendar->getDayName($day_id);
    }

}