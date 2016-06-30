<?php
namespace Toolbox\Library\Currency;

use Zend\View\Helper\AbstractHelper;


class CurrencyFormatHelper extends AbstractHelper {

    protected $countriesService;

    public function __construct(
        CurrencyMapper $currencyMapper
    )
    {
        $this->currencyMapper = $currencyMapper;
    }

    public function __invoke($currency, $value, $operator = true)
    {
        return $this->currencyMapper->getCurrencyFormat($currency ,$value ,$operator);
    }
}