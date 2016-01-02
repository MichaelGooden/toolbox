<?php
namespace Toolbox\Library\Calendar;

class Calendar
{

    public function getDays()
    {
        return [1 => "Mon" , 2 => "Tue" , 3 => "Wed" , 4 => "Thu" , 5 => "Fri" , 6 => "Sat" , 7 => "Sun"];
    }

    public function getDayName($day_id)
    {
        $dayArray = $this->getDays();

        if (isset($dayArray[$day_id]))
        {
            return $dayArray[$day_id];
        }

        return null;
    }

    public function getMonths()
    {
        return [1 => "Jan" , 2 => "Feb" , 3 => "Mar" , 4 => "Apr" , 5 => "May" , 6 => "June" , 7 => "Jul" , 8 => "Aug" , 9 => "Sep" , 10 => "Oct" , 11 => "Nov" , 12 => "Dec"];
    }

    /**
     * NB this must be updated in index.php otherwise unexpected times will occur
     * @return string
     */
    public function getTimeFormat()
    {
        return "UTC";
    }

    public function getYearFormat()
    {
        return "Y-m-d";
    }


}

