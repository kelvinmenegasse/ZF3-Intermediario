<?php

namespace Blog;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            // toda vez que chamamos nosso controller, ele entende que é um serviço
            // esse serviço tem várias formas de ser chamado, e uma delas é passando
            // várias dependências na hora dele ser criado
            // Controller\BlogController::class => InvokableFactory::class
        ],
    ],

    'router' => [
        'routes' => [
            'post' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/blog[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z0-9_-]*',
                        'id' => '[0-9]+', 
                    ],
                    'defaults' => [
                        'controller' => Controller\BlogController::class,
                        'action' => 'index'
                    ]
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'blog' => __DIR__ . "/../view",
        ],
    ],

];
