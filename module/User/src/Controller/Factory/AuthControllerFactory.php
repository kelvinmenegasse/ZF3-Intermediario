<?php

namespace User\Controller\Factory;


use User\Controller\AuthController;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationServiceInterface;

class AuthControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $authService = $container->get(AuthenticationServiceInterface::class);

        return new AuthController($authService);
    }


}