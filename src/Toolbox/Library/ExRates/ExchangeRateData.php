<?php
namespace Toolbox\Library\ExRates;

class ExchangeRateData
{

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
    public function getZarRates( $url = "http://zar.fxexchangerate.com/rss.xml" )
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

            $str = $row['title'];
            $del = ['(',')'];
            $from_to = explode( $del[0], str_replace($del, $del[0], $str) );
            $newArray[$row['title']]['from'] = $from_to[1];
            $newArray[$row['title']]['to'] = $from_to[3];
            $rate = explode( ' ' , $row['description']);
            $newArray[$row['title']]['rate'] = $rate[5];
            $newArray[$row['title']]['description'] = $row['description'];
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
    public function getEurRates( $url = "https://spreadsheets.google.com/feeds/list/0Av2v4lMxiJ1AdE9laEZJdzhmMzdmcW90VWNfUTYtM2c/1/public/basic?alt=rss" )
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

