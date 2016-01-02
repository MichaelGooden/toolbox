<?php
namespace Toolbox\Library\Countries;

use Zend\View\Helper\AbstractHelper;

class CountryNameHelper extends AbstractHelper {

    protected $countriesService;

    public function __construct(
        CountriesService $countriesService
    )
    {
        $this->cs = $countriesService;
    }

    public function __invoke($country_id)
    {
        return $this->cs->countryName($country_id)->getName();

    }
}