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
        $this->fetchExRate   = new ExchangeRateData();
        $this->exRateService = $exRateService;
    }


    /**
     * We include the method required in order to update the rates
     * @param $method
     * @return bool
     */
    public function updateAll($method)
    {
        $rates = [];

        if (method_exists($this->fetchExRate,$method))
        {
            $rates = $this->fetchExRate->$method();
        }

        if (empty($rates))
        {
            return false;
        }

        $result = false;

        foreach ( $rates AS $row )
        {
            $result = $this->updateSpecific( $row['from'] , $row['to'] , $row['rate'] );
        }

        return $result;

    }

    /**
     * @param $fromCurrency
     * @param $toCurrency
     * @param $exchangeRate
     * @return bool
     */
    public function updateSpecific( $fromCurrency , $toCurrency , $exchangeRate )
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