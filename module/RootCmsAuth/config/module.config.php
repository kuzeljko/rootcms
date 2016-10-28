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
            'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => Controller\RootCmsAuthController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login',
                            'defaults' => [
                                'action' => 'login',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/logout',
                            'defaults' => [
                                'action' => 'logout',
                            ],
                        ],
                        'may_terminate' => true,
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
            'root-cms-auth/root-cms-auth/index' => __DIR__ . '/../view/root-cms-auth/auth/index.phtml',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'auth-service' => Service\AuthenticationServiceFactory::class,
        ],
    ],
];
