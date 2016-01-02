<?php
namespace Toolbox\Library\ExRates;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Toolbox\Entity\ExchangeRate;
use Zend\Paginator\Paginator;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;

class ExchangeRateService
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $exRateRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @param ObjectRepository $exRateRepository
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectRepository $exRateRepository,
        ObjectManager $entityManager
    )
    {
        $this->exRateRepository   = $exRateRepository;
        $this->entityManager      = $entityManager;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->exRateRepository->findAll();
    }

    /**
     * @param $from_currency
     * @return mixed
     */
    public function findOneByFromCurrency($from_currency)
    {
        return $this->exRateRepository->findOneByFromCurrency($from_currency);
    }

    /**
     * @param $to_currency
     * @return mixed
     */
    public function findOneByToCurrency( $to_currency )
    {
        return $this->exRateRepository->findOneByToCurrency( $to_currency );
    }

    /**
     * This is used to return a from to rate and is used in the cron section
     * @param $fromCurrency
     * @param $toCurrency
     * @return null|object
     */
    public function findFromToRate( $fromCurrency , $toCurrency )
    {
        //Check if the rate exists
        $exRateObject =  $this->exRateRepository->findOneBy( array( 'fromCurrency' => $fromCurrency , 'toCurrency' => $toCurrency) );

        if ( ! $exRateObject instanceof ExchangeRate )
        {
            return null;
        }

       return $exRateObject;

    }

    /**
     * @param ExchangeRate $dataObject
     * @return ExchangeRate
     * @throws \Exception
     */
    public function update( ExchangeRate $dataObject )
    {
        try {
            $this->entityManager->persist($dataObject);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return $dataObject;
    }

    /**
     * @param $page
     * @param $count
     * @return Paginator
     */
    public function getPaged($page, $count) {
        $adapter    = new SelectableAdapter($this->exRateRepository);
        $paginator  = new Paginator($adapter);

        return $paginator->setCurrentPageNumber( (int) $page )->setItemCountPerPage( (int) $count );

    }


} 