<?php

namespace Blog\Model\Factory;

use Blog\Model\PostTable;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Blog\Model;

class PostTableFactory implements FactoryInterface
{
    // $container ->            container de serviços
    // $requestedName ->        o nome registrado pra essa factory (Blog\Model\PostTable)
    // $options ->              util para trabalhar com abstract factorys

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tableGateway = $container->get(Model\PostTableGateway::class);
        return new PostTable($tableGateway);
    }
}