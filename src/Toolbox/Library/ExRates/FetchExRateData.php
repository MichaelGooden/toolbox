<?php
namespace Toolbox\Library\ExRates;

class FetchExRateData
{
    /**
     * This returns an array of the methods used in this class to be used with the
     * drop down form when choosing which cron to execute
     *
     * @return array
     */
    public function getExRateMethods()
    {
        return [
            1 => 'TMC EUR',
            2 => 'Google EUR'
        ];
    }

    /**
     * This method must be inline with the getExRateMethods
     * @param int $method_id
     * @return array
     */
    public function executeMethod($method_id = 0)
    {
        if ((int)$method_id == 0) {
            return [];
        }

        switch ( $method_id ) {
            case 1:
                return $this->getExRateEurArray1();
                break;
            case 2:
                return $this->getExRateEurArray2();
                break;
            default:
                return [];
        }

    }

    /**
     * Returns a nicely formatted array from the feed URL
     * @param string $url
     * @return array
     *
     * 'AED' =>
     *    array (size=4)
     *    'from' => string 'EUR' (length=3)
     *    'to' => string 'AED' (length=3)
     *    'rate' => string '4.74487' (length=7)
     *    'description' => string '1 Euro = 4.74487 United Arab Emirates Dirham' (length=44)
     *
     *
     */
    private function getExRateEurArray1( $url = "http://themoneyconverter.com/rss-feed/EUR/rss.xml" )
    {
        //Grab data from the feed
        $xml=@simplexml_load_file($url);

        //If the feed is unreachable it will be false
        if ( ! $xml ) {
            return [];
        }

        $json = json_encode($xml);
        $exRateArray = json_decode($json,true);
        $newArray = [];

        foreach ( $exRateArray['channel']['item'] AS $key => $row )
        {
            $currency = explode( '/' , $row['title'] );

            $newArray[$currency[0]]['from'] = $currency[1];
            $newArray[$currency[0]]['to'] = $currency[0];

            $rate = explode( ' ' , $row['description']);
            $newArray[$currency[0]]['rate'] = $rate[3];

            $newArray[$currency[0]]['description'] = $row['description'];
        }

        return $newArray;

    }

    /**
     * Returns a nicely formatted array from the feed URL
     * http://currencyfeed.com/
     *
     * @param string $url
     * @return array
     *
     * 'AED' =>
     *    array (size=4)
     *    'from' => string 'EUR' (length=3)
     *    'to' => string 'AED' (length=3)
     *    'rate' => string '4.74487' (length=7)
     *    'description' => string '1 Euro = 4.74487 United Arab Emirates Dirham' (length=44)
     *
     *
     */
    private function getExRateEurArray2( $url = "https://spreadsheets.google.com/feeds/list/0Av2v4lMxiJ1AdE9laEZJdzhmMzdmcW90VWNfUTYtM2c/1/public/basic?alt=rss" )
    {
        //Grab data from the feed
        $xml=@simplexml_load_file($url);

        //If the feed is unreachable it will be false
        if ( ! $xml ) {
            return [];
        }

        $json = json_encode($xml);
        $exRateArray = json_decode($json,true);
        $newArray = [];

        if (!isset($exRateArray['channel']['item']))
        {
            return [];
        }

        foreach ( $exRateArray['channel']['item'] AS $key => $row )
        {
            if ( (!isset($row['title'])) OR (!isset($row['description'])) )
            {
                continue;
            }

            $newArray[$row['title']]['from'] = 'EUR';
            $newArray[$row['title']]['to'] = $row['title'];
            $rate = explode( ' ' , $row['description']);
            $newArray[$row['title']]['rate'] = $rate[1];
            $newArray[$row['title']]['description'] = $row['description'];
        }

        return $newArray;

    }

}

