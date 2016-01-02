<?php
namespace Toolbox\Library\ApplicationSettings;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppSettingServiceFactory implements FactoryInterface
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
        $appSettingRepository = $entityManager->getRepository('Toolbox\Entity\AppSettings');

        return new AppSettingService(
            $appSettingRepository,
            $entityManager
        );
    }

} 