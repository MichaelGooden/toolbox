<?php
namespace Toolbox\Library\ExRates;

use Toolbox\Entity\ExchangeRate;

class UpdateExchangeRate
{
    /**
     * The job of this library class is to fetch the current rates from the ex rate fetch library
     * and to update to the DB
     * @param ExchangeRateService $exRateService
     */
    public function __construct(
        ExchangeRateService $exRateService
    ) {
        $this->fetchExRate = new FetchExRateData();
        $this->exRateService = $exRateService;
    }

    public function executeMethod( $from = null , $to = null , $rate = null )
    {

        $route = 'updateSpecific';

        if ( $from == null OR $to == null OR $rate == null )
        {
            $route = 'updateAll';
        }

        switch ( $route ) {

            case 'updateAll':
                return $this->updateAll();
                break;

            case 'updateSpecific':
                return $this->updateSpecific( $from , $to , $rate );
                break;

            default:
                return [];

        }


    }

    /**
     * The feed to get the rates from as per the ExRate / FetchExRateDataTmcInterface library
     */
    private function getRates()
    {

        //While it is possible to have multiple feeds, it becomes un-manageable, a feed based on a single rate EUR/* can
        //be used to work out all ex-rate combinations i.e.: GBP/AUD wold be a matter of: EUR/GBP + EUR/AUD = (1EUR = 2GBP) + (1 EUR = 3 AUD) therefore: 2GBP = 3AUD thus 1GBP = 1.5AUD

        return $this->fetchExRate->executeMethod(2);

    }

    /**
     * Find all the ex rates in the feed
     * @return array
     */
    private function updateAll()
    {
        $rates = $this->getRates();

        foreach ( $rates AS $row )
        {
            $this->updateSpecific( $row['from'] , $row['to'] , $row['rate'] );
            //@TODO Log a check here via a listener
        }

    }

    /**
     * @param $fromCurrency
     * @param $toCurrency
     * @param $exchangeRate
     * @return bool
     */
    private function updateSpecific( $fromCurrency , $toCurrency , $exchangeRate )
    {
        //Check both directions L2R = Left to Right, R2L = Right to Left
        $exRateObjectL2R = $this->exRateService->findFromToRate( $fromCurrency , $toCurrency );

        //No rate exists so we create one
        if ( ( ! $exRateObjectL2R instanceof ExchangeRate ) )
        {
            $exRateObject = new ExchangeRate();
            $exRateObject->setFromCurrency($fromCurrency);
            $exRateObject->setToCurrency($toCurrency);
            $exRateObject->setValue($exchangeRate);
            $exRateObject->setInverse( 1 / $exchangeRate );
            $this->exRateService->update($exRateObject);
            return true;

        }

        //Update the pre-existing rate
        if ( $exRateObjectL2R instanceof ExchangeRate )
        {
            $exRateObjectL2R->setValue($exchangeRate);
            $exRateObjectL2R->setInverse( 1 / $exchangeRate );
            $this->exRateService->update($exRateObjectL2R);
            return true;

        }

        return false;

    }

}