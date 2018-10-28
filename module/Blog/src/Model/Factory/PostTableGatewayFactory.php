<?php

namespace Blog\Model\Factory;

use Blog\Model\Post;
use Interop\Container\ContainerInterface;       // usa psr-11
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class PostTableGatewayFactory
{

    // $object = new PostTableGatewayFactory(): 
    // $object();  -> chama nosso invoke após instanciar
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Post());
        return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
        // devolve a instancia do tablegateway
    }


}