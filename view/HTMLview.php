<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-26
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class HTMLview {
    private $loginMessage = "Du har loggats in";
    private $logoutMessage = "Du har loggats uuuut";
    private $message = "message";

    public function getIndexPage()
    {


        $date = $this->getDate();

        if (isset($_POST['username']))
        {
            $username = ($_POST['username']);
        }
        else {
            $username = "";
        }

        if (isset($_SESSION[$this->message]))
        {
            $message = $_SESSION[$this->message];
            $this->unsetMessageSession();
        }
        else{
            $message = "Välkommen";
        }
        return "
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type'
                content='text/html; charset=UTF-8'>
                <title>$message</title>
            </head>
            <body>
            <h2>Ej inloggad</h2>
                <p>$message</p>
                <form action='?login' method='post' >
                <label>Username</label>
                <input type='text' name='username' value='$username'>
                <label>Password</label>
                <input type='password' name='password'>
                <input type='submit' name='submit' value='submit'>
            </form>
                <p>$date</p>
            </body>
        </html>
        ";
    }

    public function getAdminPage ()
    {
        if (isset($_SESSION[$this->message]))
        {
            $message = $_SESSION[$this->message];
            $this->unsetMessageSession();
        }
        else{
         $message = "Välkommen";
        }
        return
            "<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type'
                content='text/html; charset=UTF-8'>
                <title>Inloggad</title>
            </head>
            <body>
            <h2>Inloggad</h2>
                <p>$message</p>
            <form action='?logout' method='post' >
                <input type='submit' value='Logout'>
            </form>
            </body>
        </html>";
    }

    private static function getDate()
    {

        switch(date("N"))
        {
            case "1":
                $day = "Måndag";
                break;
            case "2":
                $day = "Tisdag";
                break;
            case "3":
                $day = "Onsdag";
                break;
            case "4":
                $day = "Torsdag";
                break;
            case "5":
                $day = "Fredag";
                break;
            case "6":
                $day = "Lördag";
                break;
            case "7":
                $day = "Söndag";
                break;
        }

        switch (date("n"))
        {
            case "1":
                $month = "Januari";
                break;
            case "2":
                $month = "Februari";
                break;
            case "3":
                $month = "Mars";
                break;
            case "4":
                $month = "April";
                break;
            case "5":
                $month = "Maj";
                break;
            case "6":
                $month = "Juni";
                break;
            case "7":
                $month = "Juli";
                break;
            case "8":
                $month = "Augusti";
                break;
            case "9":
                $month = "September";
                break;
            case "10":
                $month = "Oktober";
                break;
            case "11":
                $month = "November";
                break;
            case "12":
                $month = "December";
                break;
        }

        return $day . ", den " . date("d") . " " . $month .
        " år " .  date("Y") .". Klockan är [" . date("H") .
        ":" . date("i") . ":" . date("s") . "]";

    }

    public function getUsernamePost()
    {
        if (isset($_POST['username']))
        {
            if(strlen($_POST['username'])>0)
            {
                return $_POST['username'];
            }

            else{
                throw new \Exception("Användarnamn saknas");
            }
        }
        else
        {
            throw new \Exception("Något blev fel vid inloggningen, vänligen försök igen");
        }
    }


    public function getPasswordPost()
    {
        if (isset($_POST['password']))
        {
            if(strlen($_POST['password'])>0)
            {
                return $_POST['password'];
            }

            else{
                throw new \Exception("Lösenord saknas");
            }

        }
        else
        {
            throw new \Exception("Något blev fel vid inloggningen, vänligen försök igen");
        }


    }

    public function isLoggingIn()
    {
        return isset($_GET['login']);

    }

    public function isLoggingOut()
    {
        return isset($_GET['logout']);
    }

    public function isSubmitted()
    {
        return isset($_POST['submit']);
    }
    public function setLogoutMessageSession()
    {
        $_SESSION[$this->message] = $this->logoutMessage;
    }

    public function setLoginMessageSession()
    {
        $_SESSION[$this->message] = $this->loginMessage;
    }

    public function setErrorMessageSession($errorMsg)
    {
        $_SESSION[$this->message] = $errorMsg;
    }

    public function unsetMessageSession()
    {
        unset($_SESSION[$this->message]);
    }



}