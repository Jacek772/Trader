<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/WarehousesService.php";

class WarehousesController extends AppController
{
    private $warehousesService;

    public function __construct()
    {
        parent::__construct();
        $this->warehousesService = new WarehousesService();
    }

    public function all()
    {
        $data = ["warehouses" => $this->warehousesService->getAllWarehouses()];
        echo json_encode($data, true);
    }
}