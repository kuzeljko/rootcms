<?php

/**
 * User entity.
 * 
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 * @since Oct 2016
 */

namespace RootCmsAuth\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(User $user) {
        if(!$user->isUsernameValid($user->username) || !$user->isPasswordValid($user->password)){
            return FALSE;
        }
        
        $data = array(
            'username' => $user->username,
            'password' => $user->password,
            'salt' => $user->salt,
            'created' => time()
        );

        $id = (int) $user->id;
        if ($id == 0) {
            return $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                return $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    public function deleteUser($id) {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}
