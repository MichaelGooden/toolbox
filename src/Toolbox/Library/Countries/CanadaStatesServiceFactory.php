<?php
namespace Toolbox\Library\Countries;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CanadaStatesServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        $countriesRepository = $entityManager->getRepository('Toolbox\Entity\CanadaStates');

        return new CanadaStatesService(
            $countriesRepository,
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
        return $this($serviceLocator, CanadaStatesService::class);
    }

}
