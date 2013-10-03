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

    
    /**
     * @var \view\HTMLview
     */
    private $HTMLview;

    /**
     * @var \model\user
     */
    private $userModel;

    function __construct ()
    {
    $this->HTMLview = new HTMLview();
    $this->userModel = new user();
    }

    /**
     * @return String with HTML .
     */
    public function Controll()
    {
        if ($this->HTMLview->isLoggingOut())
        {
            return $this->validateLogout();
        }
        else if ($this->userModel->isLoggedIn())
        {
         return $this->validateSession();
        }
        else if ($this->HTMLview->isThereACookie())
        {
            return $this->validateCookie();
        }
        else if ($this->HTMLview->isLoggingIn()
            && $this->HTMLview->isSubmitted())
        {
            return $this->validateLogin();
        }
        else
        {
            return $this->HTMLview->getIndexPage();
        }
    }

    /**
     * @return string with HTML, either Admin or Index.
     */
    private function validateLogout()
    {
        if ($this->userModel->isLoggedIn()){
            $this->userModel->unsetSession();
            $this->HTMLview->setLogoutMessageSession();
        }
        if ($this->HTMLview->isThereACookie())
        {
            $this->HTMLview->unsetCookie();
        }
        return $this->HTMLview->getIndexPage();
    }

    /**
     * @return string with HTML, either Admin or Index or catches exception.
     */
    private function validateSession()
    {
        try{
            if($this->userModel->isSessionValid())
            {
                return $this->HTMLview->getAdminPage();
            }
        }
        catch (\Exception $e)
        {
            $this->HTMLview->setErrorMessageSession($e->getMessage());
            return $this->HTMLview->getIndexPage();
        }
    }

    /**
     * @return string with HTML, either Admin or Index or catches exception.
     */
    private function validateCookie()
    {
        try
        {
            if($this->HTMLview->isCookieValid())
            {
                $this->HTMLview->setCookieLoginSuccessMessage();
                $this->userModel->setSession();
                return $this->HTMLview->getAdminPage();
            }
        }
        catch (\Exception $e)
        {
            $this->HTMLview->unsetCookie();
            $this->HTMLview->setErrorMessageSession($e->getMessage());
            return $this->HTMLview->getIndexPage();
        }
    }

    /**
     * @return string with HTML, either Admin or Index or catches exception.
     */
    private function validateLogin()
    {
        try {
            $this->userModel->userValidation($this->HTMLview->getUsernamePost()
                , $this->HTMLview->getPasswordPost());
            $this->HTMLview->setLoginMessageSession();
            if ($this->HTMLview->isRememberMe())
            {
                $this->HTMLview->setCookie();
                $this->HTMLview->setCookieLoginMessage();
            }
            return $this->HTMLview->getAdminPage();
        }
        catch (\Exception $e)
        {
            $this->HTMLview->setErrorMessageSession($e->getMessage());
            return $this->HTMLview->getIndexPage();
        }
    }



}