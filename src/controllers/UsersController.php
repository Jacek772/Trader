<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/UsersService.php";

// Models
require_once __DIR__."/../models/User.php";

class UsersController extends AppController
{
    private $usersService;

    public function __construct()
    {
        parent::__construct();
        $this->usersService = new UsersService();
    }

    public function all()
    {
        try {
            $idrole = $_GET["idrole"];

            $data = ["users" => $this->usersService->getUsers($idrole)];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function one()
    {
        try {
            $iduser = $_GET["iduser"];
            $data = ["user" => $this->usersService->getUserById($iduser)];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $user = new User(
                0,
                $_POST["idrole"],
                $_POST["name"],
                $_POST["surname"],
                $_POST["login"],
                $_POST["password"],
                isset($_POST["enabled"]) ? $_POST["enabled"] : 1
            );

            $this->usersService->createUser($user);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {
            $iduser = $_POST["iduser"];
            $userData = [
                "name" => $_POST["name"],
                "surname" => $_POST["surname"],
                "login" => $_POST["login"],
                "password" => $_POST["password"],
                "enabled" => $_POST["enabled"],
                "idrole" => $_POST["idrole"]
            ];

            $this->usersService->updateUser($iduser, $userData);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function remove()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split ("/\,/", $idsStr);
            $this->usersService->deleteUsers($ids);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }
}