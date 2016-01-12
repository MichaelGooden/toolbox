<?php
namespace Toolbox\Library\Countries;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsStatesServiceFactory implements FactoryInterface
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
        $countriesRepository = $entityManager->getRepository('Application\Entity\UsStates');

        return new UsStatesService(
            $countriesRepository,
            $entityManager
        );
    }

} 