<?php

namespace Blog\Controller\Factory;

use Blog\Form\PostForm;
use Blog\Model\PostTable;
use Blog\Controller\BlogController;
use Interop\Container\ContainerInterface;

class BlogControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $postTable = $container->get(PostTable::class);
        $postForm = $container->get(PostForm::class);

        return new BlogController($postTable, $postForm);
    }


}