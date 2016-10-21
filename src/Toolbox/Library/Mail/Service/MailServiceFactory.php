<?php
namespace Toolbox\Library\Mail\Service;

use Interop\Container\ContainerInterface;
use Toolbox\Library\Mail\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class MailServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['toolbox_mail'];
        $transport = \Zend\Mail\Transport\Factory::create($config['transport']);
        return new MailService(
            $container->get(PhpRenderer::class),
            $container->get(ModuleOptions::class),
            $transport
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
        return $this($serviceLocator, MailService::class);
    }
}
