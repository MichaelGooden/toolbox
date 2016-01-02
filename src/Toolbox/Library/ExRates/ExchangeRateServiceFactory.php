<?php
namespace Toolbox\Library\ExRates;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExchangeRateServiceFactory implements FactoryInterface
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
        $exchangeRateRepository = $entityManager->getRepository('Toolbox\Entity\ExchangeRate');

        return new ExchangeRateService(
            $exchangeRateRepository,
            $entityManager
        );
    }

} 