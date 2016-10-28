<?php
/**
 * Authentication Controller.
 * 
 * @author Aleksandra
 * @since Oct 2016
 */

namespace RootCmsAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;


class RootCmsAuthController extends AbstractActionController
{
    protected $userTable;
    protected $authService;
    
    const MIN_USERNAME_LEN = 5;
    const MAX_USERNAME_LEN = 20;
   
    public function __construct(AuthenticationService $authService)
    {
        // We should get the previously created AuthenticationService injected
        $this->authService = $authService;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * Login.
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();    
            
            if ($this->login($params['username'], $params['password'])) {
                $this->redirect()->toRoute('home');
            } else {
                $this->redirect()->toRoute('auth');
            }
        }
        $this->redirect()->toRoute('home');
    }
    
    /**
     * Perfrm authentication using authentication service.
     * @param type $pass
     */
    protected function login($username, $password){
             
        $adapter = $this->authService->getAdapter();
        $adapter->setIdentity($username);
        $adapter->setCredential($password);

        $result = $this->authService->authenticate();
        return $result->isValid();
    }
    
    /**
     * Logout.
     */
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        $this->redirect()->toRoute('home');
    }
    
}
