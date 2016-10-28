<?php

/**
 * Module of authentication module.
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 * @since Oct 2016
 */

namespace RootCmsAuth;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'RootCmsAuth\Model\UserTable' => function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function onBootstrap(MvcEvent $e) {
        // Get the service manager.
        $eventManager = $e->getApplication()->getEventManager();
        // Set event to retrieve user's identity for every request.
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);
    }

    public function protectPage(MvcEvent $event) {
        $match = $event->getRouteMatch();
        if (!$match) {
            // We cannot do anything without a resolved route.
            return;
        }

        // Get AuthenticationService and do the verification.
        $services = $event->getApplication()->getServiceManager();
        $authService = $services->get('auth-service');

        // If user does not have an identity yet.
        if (!$authService->hasIdentity()) {
            // Do what you want like routing to login page...
            error_log('you shell not pass');
        }
        error_log('passed');
    }

}
