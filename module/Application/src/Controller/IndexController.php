<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        $serviceManager = $this->getEvent()->getApplication()->getServiceManager();
        $authService = $serviceManager->get('auth-service');
        
        $viewModel = new ViewModel([
            'identity' => $authService->getIdentity(),
//            'theme_path' => getcwd() . '/themes/blue/'
        ]);
        
        return $viewModel;
    }
}
