<?php

/**
 * Module of authentication module.
 * 
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 * @since Oct 2016
 */

namespace RootCmsAuth;
use Zend\Mvc\MvcEvent;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;


class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap($e) {

        // pass identity info to layout
        $serviceManager = $e->getApplication()->getServiceManager();

        // dynamically load themes (layout, scripts)
        
        $renderer = $serviceManager->get('ViewRenderer'); //new PhpRenderer();
        $map = new Resolver\TemplateMapResolver(array(
            'root-cms-auth/root-cms-auth/index' => getcwd() . '/public/themes/blue/view/root-cms-auth/auth/index.phtml',
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
