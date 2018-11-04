<?php
namespace Blog\Controller\Factory;

use Blog\Controller\PostController;
use Blog\Model\PostTable;
use Interop\Container\ContainerInterface;

class PostControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $postTable = $container->get(PostTable::class);
        return new PostController($postTable);
    }
}
