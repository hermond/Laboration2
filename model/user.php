<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-27
 * Time: 00:02
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class user {

    private $setCookie = false;
    private static $CorrectUser = "axel";
    private static $CorrectPassword = "losenord";
    const loggedIn = "LoggedIn";

    private function getUserName()
    {
        return self::$CorrectUser;
    }
    private function getPassword()
    {
        return self::$CorrectPassword;
    }

    public function userValidation($username, $password)
    {
        if($username == $this->getUserName() && $password == $this->getPassword())
        {
          $this->setSession();
            if($this->setCookie)
            {
                $this->setCookie();
            }
            return true;
        }
        else{
            throw new \Exception("Fel användarnamn eller lösenord");
        }
    }

    public function setSession()
    {
        $_SESSION[self::loggedIn] = True;
    }

    public function unsetSession()
    {
        unset($_SESSION[self::loggedIn]);
    }
    //TODO Fixa koll på kaka också
    public function isLoggedIn()
    {
         if(isset($_SESSION[self::loggedIn])||isset($_COOKIE['user']))
         {
             return true;
         }
         else
         {
             return false;
         }

    }

    public function setCookieOrNot ($bool)
    {
        if($bool){
         $this->setCookie = true;
        }
        else
        {
            $this->setCookie = false;
        }

    }

    public function setCookie()
    {
        setcookie("user", "sklasgyoeksg", time() + 200000);
    }


}