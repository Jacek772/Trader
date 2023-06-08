<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Role.php";

// Services
require_once __DIR__."/../services/RolesService.php";

class RolesInitializer implements IInitializer
{
    private static $rolesData = [
        [
            "name" => "Administrator",
            "description" => "Administrator role"
        ],
        [
            "name" => "Trader",
            "description" => "Trader role"
        ],
        [
            "name" => "Client",
            "description" => "Client role"
        ]
    ];

    private $rolesService;

    public function __construct()
    {
        $this->rolesService = new RolesService();
    }

    public function initialize(): void
    {
        foreach (self::$rolesData as $roleData)
        {
            $role = new Role(0, $roleData["name"], $roleData["description"]);
            $this->rolesService->createRoleIfNotExists($role);
        }
    }
}