<?php

namespace User;

use User\Controller\AuthController;
use User\Controller\Factory\AuthControllerFactory;
use User\Service\Factory\AuthenticationServiceFactory;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;

use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        // pega nosso eventManager
        $eventManager = $e->getApplication()->getEventManager();

        // pegamos nosso container de serviços
        $container = $e->getApplication()->getServiceManager();

        // attach adiciona uma ação quando um determinado evento acontecer
        // precisamos informar qual evento queremos vigiar
        // escolhemos dispatch porque significa que nossa aplicação já está montada, nossas rotas estão montadas
        // e nossa aplicação vai direcionar de acordo com nossa rota a ação pro controller (ainda nao aconteceu, mas irá acontecer no dispatch)
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, 
            function(MvcEvent $e) use($container) {

                $match = $e->getRouteMatch();   // pegamos a rota
                
                $authService = $container->get(AuthenticationServiceInterface::class); // pegamos nosso serviço
                
                $routeName = $match->getMatchedRouteName();

                if ($authService->hasIdentity()) {
                    // se está autenticado, retorna a rota
                    return;
                } elseif (strpos($routeName, 'admin') !== false) {
                    $match->setParam('controller', AuthController::class)
                        ->setParam('action', 'login');
                }

            }, 100  // ordem de prioridade, quanto maior, maior o nivel de prioridade na execucao
        );
    }

    public function getConfig()
    {

        return include __DIR__ . "/../config/module.config.php";

    }

    public function getServiceConfig()
    {
        return [
            'aliases' => [
                AuthenticationService::class => AuthenticationServiceInterface::class
            ],
            'factories' => [
                AuthenticationServiceInterface::class => AuthenticationServiceFactory::class
            ],
        ];

    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                AuthController::class => AuthControllerFactory::class
            ],
        ];
    }

}
