<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/RolesService.php";

class RolesController extends AppController
{
    private $rolesService;

    public function __construct()
    {
        parent::__construct();
        $this->rolesService = new RolesService();
    }

    public function all()
    {
        $data = ["roles" => $this->rolesService->getAllRoles()];
        echo json_encode($data, true);
    }
}