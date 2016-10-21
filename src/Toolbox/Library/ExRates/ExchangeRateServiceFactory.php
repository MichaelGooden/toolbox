<?php
namespace Toolbox\Library\ExRates;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExchangeRateServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        $exchangeRateRepository = $entityManager->getRepository('Toolbox\Entity\ExchangeRate');

        return new ExchangeRateService(
            $exchangeRateRepository,
            $entityManager
        );
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, ExchangeRateService::class);
    }
}
