<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/User.php";

// Services
require_once __DIR__."/../services/UsersService.php";
require_once __DIR__."/../services/RolesService.php";

class UsersInitializer implements IInitializer
{
    private static $usersData = [
        [
            "roleName" => "Administrator",
            "name" => "Administrator",
            "surname" => "Administrator",
            "login" => "admin",
            "password" => "admin"
        ],
        [
            "roleName" => "Trader",
            "name" => "Trader",
            "surname" => "Trader",
            "login" => "trader",
            "password" => "trader"
        ],
        [
            "roleName" => "Client",
            "name" => "Client",
            "surname" => "Client",
            "login" => "client",
            "password" => "client"
        ]
    ];

    private $usersService;
    private $rolesService;

    public function __construct()
    {
        $this->usersService = new UsersService();
        $this->rolesService = new RolesService();
    }

    public function initialize(): void
    {
        foreach (self::$usersData as $userData)
        {
            $role = $this->rolesService->getRole($userData["roleName"]);
            if(!$role)
            {
                throw new Exception("Role ".$userData["roleName"]." does not exist!");
            }

            $user = new User(0, $role->getIdRole(), $userData["name"], $userData["surname"], $userData["login"], $userData["password"]);
            $this->usersService->createUserIfNotExists($user);
        }
    }

}