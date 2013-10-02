<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-26
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

namespace controller;



use model\user;
use view\HTMLview;

class Login {

    private $HTMLview;
    private $userModel;

    function __construct ()
    {
    $this->HTMLview = new HTMLview();
    $this->userModel = new user();

    }

    public function Controll()
    {

        if ($this->HTMLview->isLoggingOut())
        {
            if ($this->userModel->isLoggedIn()){
            $this->userModel->unsetSession();
            $this->HTMLview->setLogoutMessageSession();
            }
            return $this->HTMLview->getIndexPage();
        }
        else if ($this->userModel->isLoggedIn())
        {
            return $this->HTMLview->getAdminPage();
        }
        else if ($this->HTMLview->isLoggingIn() && $this->HTMLview->isSubmitted())
        {
            return $this->validateLogin();
        }
        else
        {
            return $this->HTMLview->getIndexPage();
        }

    }

    public function validateLogin()
    {
        try {
            $this->userModel->setCookieOrNot($this->HTMLview->isRememberMe());
            $this->userModel->userValidation($this->HTMLview->getUsernamePost(), $this->HTMLview->getPasswordPost());

            $this->HTMLview->setLoginMessageSession();
            return $this->HTMLview->getAdminPage();
        }
        catch (\Exception $e)
        {
            $this->HTMLview->setErrorMessageSession($e->getMessage());
            return $this->HTMLview->getIndexPage();
        }

    }

}