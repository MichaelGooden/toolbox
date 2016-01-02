<?php
namespace Toolbox\Library\Countries;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class CountriesService
{
    protected $countriesRepository;
    protected $entityManager;

    public function __construct(
        ObjectRepository $countriesRepository,
        ObjectManager $entityManager
    )
    {
        $this->countriesRepository = $countriesRepository;
        $this->entityManager = $entityManager;
    }

    public function getCountries()
    {
        return $this->countriesRepository->findAll();
    }

    public function getCountriesSelect()
    {
        $cArray = $this->countriesRepository->findAll();
        $nArray = array();
        foreach  ($cArray AS $row) {
            $nArray[$row->getId()] = $row->getName();
        }

       return $nArray;
    }

    public function countryName($id) {
       $object =  $this->countriesRepository->find($id);
       return $object;
    }


}