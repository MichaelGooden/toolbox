<?php
namespace Toolbox\Library\Countries;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class CanadaStatesService
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $usStatesRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    public function __construct(
        ObjectRepository $usStatesRepository,
        ObjectManager $entityManager
    )
    {
        $this->usStatesRepository = $usStatesRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getStates()
    {
        return $this->usStatesRepository->findAll();
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id) {
       $object =  $this->usStatesRepository->find($id);
       return $object;
    }

    public function getIso2($id)
    {
        $stateObject = $this->find($id);

        return $stateObject->getCode2();
    }


}