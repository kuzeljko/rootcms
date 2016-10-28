<?php

/**
 * Validation class for User table.
 * 
 * @author Aleksandra <aleksandranspasojevic@gmail.com>
 */

namespace RootCmsAuth\Model;

use Zend\Validator\StringLength;
use Zend\Validator\Regex;

//TODO: refactor to a service or helper class?
class User {

    public $id;
    public $username;
    public $password;
    public $salt;

    /**
     * 
     * @param type $data
     */
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->salt = (!empty($data['salt'])) ? $data['salt'] : null;
    }

    /**
     * Check if requested username is valid.
     * @param type $username
     * @return boolean
     */
    protected function isUsernameValid($username) {
        $validatorString = new StringLength(array(
            'min' => self::MIN_USERNAME_LEN,
            'max' => self::MAX_USERNAME_LEN));

        $validatorAlfanum = new Regex('/^\w+$/');
        if (empty($username) || !$validatorString->isValid($username) || !$validatorAlfanum->isValid($username)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Check if requested Pass is valid.
     * @param type $pass
     */
    protected function isPasswordValid($pass) {
        // TODO: implement
        return FALSE;
    }

}
