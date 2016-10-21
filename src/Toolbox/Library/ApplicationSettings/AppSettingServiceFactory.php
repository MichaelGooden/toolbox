<?php
namespace Toolbox\Library\ApplicationSettings;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppSettingServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        $appSettingRepository = $entityManager->getRepository('Toolbox\Entity\AppSettings');

        return new AppSettingService(
            $appSettingRepository,
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
        return $this($serviceLocator, AppSettingService::class);
    }
}
