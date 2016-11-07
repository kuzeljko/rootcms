<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;
use Zend\Mvc\MvcEvent;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;



class Module
{
    const VERSION = '3.0.2dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap($e) {

        // pass identity info to layout
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $authService = $serviceManager->get('auth-service');
        $viewModel->identity = $authService->getIdentity();
        $viewModel->theme_path = '/themes/blue/';

        // dynamically load themes (layout, scripts)
        
        $renderer = $serviceManager->get('ViewRenderer'); //new PhpRenderer();
        $map = new Resolver\TemplateMapResolver(array(
            'layout'      => getcwd() . '/public/themes/blue/view/layout/layout.phtml',
            'application/index/index' => getcwd() . '/public/themes/blue/view/application/index/index.phtml',
        ));
        $resolver = new Resolver\AggregateResolver($map);
        $renderer->setResolver($resolver);

        $stack = new Resolver\TemplatePathStack(array(
            'script_paths' => array(
//                __DIR__ . '/view',
                getcwd() . '/public/themes/blue/view'
            )
        ));

        $resolver->attach($map)    // this will be consulted first
                 ->attach($stack);
    }
}
