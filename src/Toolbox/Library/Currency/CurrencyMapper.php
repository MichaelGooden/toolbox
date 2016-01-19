<?php
namespace Toolbox\Library\Currency;

use Toolbox\Entity\ExchangeRate;
use Toolbox\Library\ExRates\ExchangeRateService;
use Toolbox\Library\Session\SessionService;

class CurrencyMapper
{
    /**
     * @param ExchangeRateService $exchangeRateService
     * @param $default_currency
     */
    function __construct(
        ExchangeRateService $exchangeRateService,
        $default_currency
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->defaultCurrency = $default_currency;
        $this->sessionService = new SessionService();
    }

    /**
     * Returns the currency notation
     * @param $currency
     * @return bool|mixed
     */
    public function getCurrencySymbol( $currency )
    {
        $symbolArray = $this->getCurrencySymbolArray();

        if ($currency == '') {
            $currency = $this->getDefaultCurrency();
        }

        if ( ! isset( $symbolArray[$currency] ) )
        {
            return false;
        }

        return '&#x'.$symbolArray[$currency].';';
    }

    /**
     * i.e. 'EUR' => '&euro;' , 'USD' => '$'
     * @return array
     */
    public function getCurrencySymbolArray()
    {
        $currencies = $this->getAllCurrencies();

        $symbolArray  = [];

        foreach ($currencies AS $key => $array)
        {
            $symbolArray[$key] =  $array[1];
        }

        return $symbolArray;
    }

    /**
     * i.e. 'EUR' , 'USD'
     * @return array
     */
    public function getCurrencyArray()
    {
        $currencies = $this->getAllCurrencies();

        $currencyArray  = [];

        foreach ($currencies AS $key => $array)
        {
            $currencyArray[] = $key;
        }

        return $currencyArray;
    }

    /**
     * Retunrs the name of the currency
     * @param $currency
     * @return bool
     */
    public function getCurrencyName( $currency )
    {
        $nameArray = $this->getCurrencyNameArray();

        if ( ! isset( $nameArray[$currency] ) )
        {
            return false;
        }

        return $nameArray[$currency];
    }

    /**
     * i.e. 'GTQ' => Guatemala, Quetzales
     * @return array
     */
    public function getCurrencyNameArray()
    {
        $currencies = $this->getAllCurrencies();

        $nameArray  = [];

        foreach ($currencies AS $key => $array)
        {
            $nameArray[$key] =  $array[0];
        }

        return $nameArray;
    }

    /**
     * You can update this to pull the default value from the configs.
     * The default currency MUST be the BASE currency i.e. the left or from currency in your db table
     * e.g EUR
     * @return mixed
     */
    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    /**
     * NOTATION: SYM = Symbol, ISO3 = EUR, ZAR... etc.
     * @param float $total
     * @param null $currency
     * @param string $notation
     * @return string
     */
    public function formatCurrency( $total = 0.00 , $currency = null , $notation = 'SYM')
    {
        $currency = ($currency != null) ? $currency : $this->getDefaultCurrency();

        /**
         * Get the currency symbol
         */
        $symbol = $this->getCurrencySymbol($currency);

        $total = round($total,2);
        $total = sprintf ("%.2f", $total);

        if ($notation == 'SYM')
        {
            return $symbol.$total;
        }

        if ($notation == 'ISO3')
        {
            return $currency.' '.$total;
        }

        return $currency.' '.$total;

    }

    /**
     * A list of default or sub-currencies (used in the menu bar)
     * @return mixed
     */
    public function getDefaultCurrencies()
    {
        return [ 'ZAR' , 'USD' ,  'GBP' , 'EUR'  ];
    }

    /**
     * @return bool
     */
    public function getSessionCurrency()
    {

        if ( $sessionCurrency = $this->sessionService->getDataValue('currency'))
        {
            return $sessionCurrency;

        }

        $currency_array =  $this->sessionService->setData('currency' , $this->getDefaultCurrency() );

        return $currency_array['currency'];
    }

    /**
     * Supported currencies should be used as the root for any module that relies on currencies, i.e. the exchange rate module
     * @return mixed
     */
    public function getSupportedCurrencies()
    {
        return [ 'EUR' , 'USD', 'CAD' , 'AUD', 'GBP' , 'ZAR'];
    }

    /**
     * This provides information to  Form/View/Helper/FormElement/php
     * @return array
     */
    public function getCurrencySelect()
    {
        $array    = $this->getCurrencyArray();

        $newArray = array();

        foreach ( $array AS $key => $name )
        {
            $newArray[$name] = $name;
        }

        return $newArray;
    }

    /**
     * This returns the exchange rate between two given currencies
     * We check for: base -> variable, variable -> base, variable -> variable, base -> base
     *
     * TABLE STRUCTURE:
    +----+----------------------+------------------------+--------+---------+
    | id | from_currency (base) | to_currency (variable) | value  | inverse |
    +----+----------------------+------------------------+--------+---------+
    |  1 | EUR                  | GBP                    | 0.744  | 1.34    |
    |  2 | EUR                  | USD                    | 1.0881 | 0.919   |
    |  3 | EUR                  | ZAR                    | 17.44  | 0.0573  |
    +----+----------------------+------------------------+--------+---------+
     *
     * @param $from_currency
     * @param $to_currency
     * @return bool|float|int
     */
    public function getExchangeRate( $from_currency , $to_currency )
    {

        /**
         * If currencies are the same: base -> base or variable -> variable (makes no difference, we always return 1)
         */
        if ($from_currency == $to_currency)
        {
            return 1;
        }

        $base_currency = $this->getDefaultCurrency();

        if ($base_currency == '')
        {
            return false;
        }

        $currency_array = [$from_currency,$to_currency];

        $conversion_type = false;

        $toObject   = false;
        $fromObject = false;

        /**
         * Check conversion type
         */
        if (in_array($base_currency,$currency_array))
        {

            if ($from_currency == $base_currency)
            {
                //This is a base to variable conversion
                $conversion_type = 1;
            }

            if ($to_currency == $base_currency)
            {
                //This is a variable to base conversion
                $conversion_type = 2;
            }

        } else {
            //We have a variable to variable conversion
            $conversion_type = 3;
        }

        if (!$conversion_type)
        {
            return false;
        }

        /**
         * Make sure we have objects for the from and to currencies in the table
         */
        if (in_array($conversion_type,[1,2]))
        {
            //From currency will be "base" and to currency will be variable, make sure we have the to_currency
            if ($conversion_type == 1)
            {
                $toObject =  $this->exchangeRateService->findOneByToCurrency($to_currency);

                if ( ! $toObject instanceof ExchangeRate )
                {
                    return false;
                }

            }

            //To currency is base and the from currency is variable, check the from_currency
            if ($conversion_type == 2)
            {
                $fromObject = $this->exchangeRateService->findOneByToCurrency($from_currency);

                if ( ! $fromObject instanceof ExchangeRate )
                {
                    return false;
                }

            }

        }
        /**
         * We are dealing with a variable to variable conversion so we must check that both from and to exist
         */
        else {
            $fromObject = $this->exchangeRateService->findOneByToCurrency($from_currency);
            $toObject   = $this->exchangeRateService->findOneByToCurrency($to_currency);

            if ( ! $toObject instanceof ExchangeRate )
            {
                return false;
            }

            if ( ! $fromObject instanceof ExchangeRate )
            {
                return false;
            }

        }


        /**
         * Make sure a conversion type has been set
         */
        if (!$conversion_type)
        {
            return false;
        }

        switch ($conversion_type) {
            case 1:
                if (!$toObject)
                {
                    return false;
                }
                return $toObject->getValue();
                break;
            case 2:
                if (!$fromObject)
                {
                    return false;
                }
                return $fromObject->getInverse();
                break;

            case 3:
                if ( (!$fromObject) OR (!$toObject) )
                {
                    return false;
                }

                if ($fromObject->getValue() == 0 OR $toObject->getValue() == 0)
                {
                    return false;
                }
                return 1 / $fromObject->getValue() * $toObject->getValue();
                break;
        }


        return false;

    }

    /**
     * @return array
     */
    private function getAllCurrencies()
    {
        return $currencies = array(
            "ALL"=> array("Albania, Leke", "4c, 65, 6b"),
            "AFN"=> array("Afghanistan, Afghanis", "60b"),
            "ARS"=> array("Argentina, Pesos", "24"),
            "AWG"=> array("Aruba, Guilders (also called Florins)", "192"),
            "AUD"=> array("Australia, Dollars", "24"),
            "AZN"=> array("Azerbaijan, New Manats", "43c, 430, 43d"),
            "BSD"=> array("Bahamas, Dollars", "24"),
            "BBD"=> array("Barbados, Dollars", "24"),
            "BYR"=> array("Belarus, Rubles", "70, 2e"),
            "BZD"=> array("Belize, Dollars", "42, 5a, 24"),
            "BMD"=> array("Bermuda, Dollars", "24"),
            "BOB"=> array("Bolivia, Bolivianos", "24, 62"),
            "BAM"=> array("Bosnia and Herzegovina, Convertible Marka", "4b, 4d"),
            "BWP"=> array("Botswana, Pulas", "50"),
            "BGN"=> array("Bulgaria, Leva", "43b, 432"),
            "BRL"=> array("Brazil, Reais", "52, 24"),
            "BND"=> array("Brunei Darussalam, Dollars", "24"),
            "KHR"=> array("Cambodia, Riels", "17db"),
            "CAD"=> array("Canada, Dollars", "24"),
            "KYD"=> array("Cayman Islands, Dollars", "24"),
            "CLP"=> array("Chile, Pesos", "24"),
            "CNY"=> array("China, Yuan Renminbi", "a5"),
            "COP"=> array("Colombia, Pesos", "24"),
            "CRC"=> array("Costa Rica, Colón", "20a1"),
            "HRK"=> array("Croatia, Kuna", "6b, 6e"),
            "CUP"=> array("Cuba, Pesos", "20b1"),
            "CZK"=> array("Czech Republic, Koruny", "4b, 10d"),
            "DKK"=> array("Denmark, Kroner", "6b, 72"),
            "DOP"=> array("Dominican Republic, Pesos", "52, 44, 24"),
            "XCD"=> array("East Caribbean, Dollars", "24"),
            "EGP"=> array("Egypt, Pounds", "a3"),
            "SVC"=> array("El Salvador, Colones", "24"),
            "EEK"=> array("Estonia, Krooni", "6b, 72"),
            "EUR"=> array("Euro", "20ac"),
            "FKP"=> array("Falkland Islands, Pounds", "a3"),
            "FJD"=> array("Fiji, Dollars", "24"),
            "GHC"=> array("Ghana, Cedis", "a2"),
            "GIP"=> array("Gibraltar, Pounds", "a3"),
            "GTQ"=> array("Guatemala, Quetzales", "51"),
            "GGP"=> array("Guernsey, Pounds", "a3"),
            "GYD"=> array("Guyana, Dollars", "24"),
            "HNL"=> array("Honduras, Lempiras", "4c"),
            "HKD"=> array("Hong Kong, Dollars", "24"),
            "HUF"=> array("Hungary, Forint", "46, 74"),
            "ISK"=> array("Iceland, Kronur", "6b, 72"),
            "INR"=> array("India, Rupees", "20a8"),
            "IDR"=> array("Indonesia, Rupiahs", "52, 70"),
            "IRR"=> array("Iran, Rials", "fdfc"),
            "IMP"=> array("Isle of Man, Pounds", "a3"),
            "ILS"=> array("Israel, New Shekels", "20aa"),
            "JMD"=> array("Jamaica, Dollars", "4a, 24"),
            "JPY"=> array("Japan, Yen", "a5"),
            "JEP"=> array("Jersey, Pounds", "a3"),
            "KZT"=> array("Kazakhstan, Tenge", "43b, 432"),
            "KES"=> array("Kenyan Shilling", "4b, 73, 68, 73"),
            "KGS"=> array("Kyrgyzstan, Soms", "43b, 432"),
            "LAK"=> array("Laos, Kips", "20ad"),
            "LVL"=> array("Latvia, Lati", "4c, 73"),
            "LBP"=> array("Lebanon, Pounds", "a3"),
            "LRD"=> array("Liberia, Dollars", "24"),
            "LTL"=> array("Lithuania, Litai", "4c, 74"),
            "MKD"=> array("Macedonia, Denars", "434, 435, 43d"),
            "MYR"=> array("Malaysia, Ringgits", "52, 4d"),
            "MUR"=> array("Mauritius, Rupees", "20a8"),
            "MXN"=> array("Mexico, Pesos", "24"),
            "MNT"=> array("Mongolia, Tugriks", "20ae"),
            "MZN"=> array("Mozambique, Meticais", "4d, 54"),
            "NAD"=> array("Namibia, Dollars", "24"),
            "NPR"=> array("Nepal, Rupees", "20a8"),
            "ANG"=> array("Netherlands Antilles, Guilders (also called Florins)", "192"),
            "NZD"=> array("New Zealand, Dollars", "24"),
            "NIO"=> array("Nicaragua, Cordobas", "43, 24"),
            "NGN"=> array("Nigeria, Nairas", "20a6"),
            "KPW"=> array("North Korea, Won", "20a9"),
            "NOK"=> array("Norway, Krone", "6b, 72"),
            "OMR"=> array("Oman, Rials", "fdfc"),
            "PKR"=> array("Pakistan, Rupees", "20a8"),
            "PAB"=> array("Panama, Balboa", "42, 2f, 2e"),
            "PYG"=> array("Paraguay, Guarani", "47, 73"),
            "PEN"=> array("Peru, Nuevos Soles", "53, 2f, 2e"),
            "PHP"=> array("Philippines, Pesos", "50, 68, 70"),
            "PLN"=> array("Poland, Zlotych", "7a, 142"),
            "QAR"=> array("Qatar, Rials", "fdfc"),
            "RON"=> array("Romania, New Lei", "6c, 65, 69"),
            "RUB"=> array("Russia, Rubles", "440, 443, 431"),
            "SHP"=> array("Saint Helena, Pounds", "a3"),
            "SAR"=> array("Saudi Arabia, Riyals", "fdfc"),
            "RSD"=> array("Serbia, Dinars", "414, 438, 43d, 2e"),
            "SCR"=> array("Seychelles, Rupees", "20a8"),
            "SGD"=> array("Singapore, Dollars", "24"),
            "SBD"=> array("Solomon Islands, Dollars", "24"),
            "SOS"=> array("Somalia, Shillings", "53"),
            "ZAR"=> array("South Africa, Rand", "52"),
            "KRW"=> array("South Korea, Won", "20a9"),
            "LKR"=> array("Sri Lanka, Rupees", "20a8"),
            "SEK"=> array("Sweden, Kronor", "6b, 72"),
            "CHF"=> array("Switzerland, Francs", "43, 48, 46"),
            "SRD"=> array("Suriname, Dollars", "24"),
            "SYP"=> array("Syria, Pounds", "a3"),
            "TWD"=> array("Taiwan, New Dollars", "4e, 54, 24"),
            "THB"=> array("Thailand, Baht", "e3f"),
            "TTD"=> array("Trinidad and Tobago, Dollars", "54, 54, 24"),
            "TRY"=> array("Turkey, Lira", "54, 4c"),
            "TRL"=> array("Turkey, Liras", "20a4"),
            "TVD"=> array("Tuvalu, Dollars", "24"),
            "UAH"=> array("Ukraine, Hryvnia", "20b4"),
            "GBP"=> array("United Kingdom, Pounds", "a3"),
            "USD"=> array("United States of America, Dollars", "24"),
            "UYU"=> array("Uruguay, Pesos", "24, 55"),
            "UZS"=> array("Uzbekistan, Sums", "43b, 432"),
            "VEF"=> array("Venezuela, Bolivares Fuertes", "42, 73"),
            "VND"=> array("Vietnam, Dong", "20ab"),
            "YER"=> array("Yemen, Rials", "fdfc"),
            "ZWD"=> array("Zimbabwe, Zimbabwe Dollars", "5a, 24"));
    }


}