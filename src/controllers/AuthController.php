<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/AuthService.php";

// Models
require_once __DIR__."/../models/User.php";

class AuthController extends AppController
{
    private $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    // POST
    public function login()
    {
        $login = isset($_POST["login"]) ? $_POST["login"] : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;

        $loginResult = $this->authService->login($login, $password);
        if($loginResult["success"])
        {
            $_SESSION["logged"] = true;
            $_SESSION["user"] = $loginResult["user"];
            return header('Location: /home');
        }
        $_SESSION["logged"] = false;
        return $this->render("index",  ["messages" => $loginResult["messages"]]);
    }

    public function logout()
    {
        $_SESSION["logged"] = false;
        $_SESSION["user"] = null;
        return header('Location: /');
    }
}