<?php
/**
 * Custom authentication service.
 * 
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 * @since Oct 2016
 */
namespace RootCmsAuth\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as Storage;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Zend\Crypt\Password\Bcrypt;    

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Get data from config files.
        $config = $container->get('configuration');

        // Configure DbAdapter with set-up information from config files.
        $dbAdapter = new DbAdapter($config['db']); // Mysqli driver working in other modules
            
        $authAdapter = new AuthAdapter($dbAdapter, 'user', 'username', 'password');
        
        $credentialValidationCallback = function($dbCredential, $requestCredential) use ($authAdapter, $dbAdapter) {
            $uname = $authAdapter->getIdentity();
            $res = $dbAdapter->createStatement('SELECt salt FROM user WHERE username=?;')->execute([$uname])->current();
            if(empty($res['salt'])){
               return false; 
            }
            $salt = $res['salt'];
            $bcrypt = new Bcrypt([
                'salt' => $salt,
                'cost' => 11
                ]);
            $isValid = $bcrypt->verify($requestCredential, $dbCredential);
            return $isValid;
        };
        $authAdapter->setCredentialValidationCallback($credentialValidationCallback);
        
        // Configure session storage.
        $storage = new Storage();
        
        // Return AuthenticationService.
        return new AuthenticationService($storage, $authAdapter);
    }
}