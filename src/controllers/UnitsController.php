<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/UnitsService.php";


class UnitsController extends AppController
{
    private $unitsService;

    public function __construct()
    {
        parent::__construct();
        $this->unitsService = new UnitsService();
    }

    public function all()
    {
        try {
            $data = ["units" => $this->unitsService->getAllUnits()];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }
}