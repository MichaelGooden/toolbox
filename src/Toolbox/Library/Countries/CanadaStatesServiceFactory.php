<?php
namespace Toolbox\Library\Countries;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CanadaStatesServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $countriesRepository = $entityManager->getRepository('Toolbox\Entity\CanadaStates');

        return new CanadaStatesService(
            $countriesRepository,
            $entityManager
        );
    }

} 