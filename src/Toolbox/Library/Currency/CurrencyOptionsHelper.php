<?php
namespace Toolbox\Library\Currency;

use Toolbox\Library\Session\SessionService;
use Zend\View\Helper\AbstractHelper;


class CurrencyOptionsHelper extends AbstractHelper {

    /**
     * @param CurrencyMapper $currencyMapper
     */
    public function __construct(
        CurrencyMapper $currencyMapper
    )
    {
        $this->sessionService = new SessionService();
        $this->currencyMapper = $currencyMapper;
    }


    public function __invoke($settings)
    {

        /**
         * Set the CASE for settings
         */
        $settings = strtoupper($settings);

        /**
         * Get the applications default currency to use as a fallback
         */
        $setCurrency = $this->currencyMapper->getDefaultCurrency();

        /**
         *  Only show the supported currencies
         */
        if ($settings == 'SUPPORTED')
        {
            $supportedCurrencies = $this->currencyMapper->getSupportedCurrencies();
        }

        if ($settings == 'DEFAULTS')
        {
            $supportedCurrencies = $this->currencyMapper->getDefaultCurrencies();
        }

        if (empty($supportedCurrencies))
        {
            $supportedCurrencies =  [$setCurrency];
        }

        /**
         * If a currency is set, we set it
         */
        if ( $sessionCurrency = $this->sessionService->getDataValue('currency') )
        {
            /**
             * Make sure the set currency exists
             */
            if ( in_array($sessionCurrency,$this->currencyMapper->getCurrencyArray()))
            {
                $setCurrency = $sessionCurrency;
            }
        }

        /**
         * Set the display currency
         */
        if ($settings == 'SUPPORTED') {
            $setCurrencyName = "<br/><br/>Currency:: ".$this->currencyMapper->getCurrencyName($setCurrency); //"<p><br/>Currency is set to: ".$setCurrency."</p>";
        }  else {
            $setCurrencyName = " :: ".$setCurrency;
        }

        $returnString = '<li class="shop-currencies">';


        $i = 1;
        foreach ($supportedCurrencies AS $currency)
        {
            $class = '';

            /**
             * We must set the class if it matches the set currency
             */
            if ($setCurrency == $currency)
            {
                $class = 'class="current"';
            }

            if ($settings = 'ALL') {
                $currencySymbol = $this->currencyMapper->getCurrencySymbol($currency);
            }  else {
                $currencySymbol = $this->currencyMapper->getCurrencySymbol($currency);
            }

            $returnString .= '<a href="#" id="'.$currency.'" data-currency="'.$currency.'" '.$class.'>'.$currencySymbol.'</a>';

            if ($i % 14 == 0)
            {
                $returnString .= '<br/>';
            }

            $i ++;
        }

        $returnString .= ''.$setCurrencyName.'</li>';

        return $returnString;

    }
}