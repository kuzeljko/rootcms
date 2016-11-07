<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        
        // define here which theme is being used:
        'base_path' => 'themes/'. \Application\Module::CURRENT_THEME.'/',
        'template_path_stack' => [
            'application' => getcwd() . '/public/themes/'.\Application\Module::CURRENT_THEME.'/view',
        ],
        'template_map' => [
            'layout/layout'           => getcwd() . '/public/themes/'.\Application\Module::CURRENT_THEME.'/view/layout/layout.phtml',
            'application/index/index' => getcwd() . '/public/themes/'.\Application\Module::CURRENT_THEME.'/view/application/index/index.phtml',
            'error/404'               => getcwd() . '/public/themes/'.\Application\Module::CURRENT_THEME.'/view/error/404.phtml',
            'error/index'             => getcwd() . '/public/themes/'.\Application\Module::CURRENT_THEME.'/view/error/index.phtml',
        ],
    ],
];
