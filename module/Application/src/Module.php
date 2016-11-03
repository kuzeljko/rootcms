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

        // dynamically load themes (layout, scripts)
        
    }


}
