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
    private $username;
    private $password;

    function __construct ()
    {
    $this->HTMLview = new HTMLview();
    $this->userModel = new user();
    $this->username = $this->HTMLview->getUsernamePost();
    $this->password = $this->HTMLview->getPasswordPost();
    }

    public function Controll()
    {

        if ($this->HTMLview->isLoggingOut())
        {
            if ($this->userModel->isLoggedIn()){
            $this->userModel->unsetSession();
            $this->HTMLview->setLogoutMessageSession();
            }
            return $this->HTMLview->getIndexPage("Du har loggat ut","Du är nu utloggad", "");
        }
        else if ($this->userModel->isLoggedIn())
        {
            return $this->HTMLview->getAdminPage("Inloggad", "");
        }
        else if ($this->HTMLview->isLoggingIn())
        {
            return $this->validateLogin();
        }
        else
        {
            return $this->HTMLview->getIndexPage("Välkommen", "", "");
        }


    }

    public function validateLogin()
    {
        try {
            $this->userModel->userValidation($this->username, $this->password);
            return $this->HTMLview->getAdminPage("Du är inloggad", "Inloggningen lyckades");
        }
        catch (\Exception $e)
        {
            return $this->HTMLview->getIndexPage($e->getMessage(), $e->getMessage() , $this->username);
        }


    }



}