<?php

namespace RootCmsAuth;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;
use RootCmsAuth\Controller\RootCmsAuthController;

return [
    'controllers' => [
        'factories' => [
            Controller\RootCmsAuthController::class => //-InvokableFactory::class,
            function($container) {
                    $serv = $container->get('auth-service');
                    return new RootCmsAuthController($serv);
                },
        ],
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\RootCmsAuthController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'validate' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/validate',
                            'defaults' => [
                                'action' => 'validate',
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'root-cms-auth/root-cms-auth/index' => __DIR__ . '/../view/root-cms-auth/login/index.phtml',
            'root-cms-auth/root-cms-auth/validate' => __DIR__ . '/../view/root-cms-auth/login/validate.phtml',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'auth-service' => Service\AuthenticationServiceFactory::class,
        ],
    ],
];
