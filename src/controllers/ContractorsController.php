<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/ContractorsService.php";

class ContractorsController extends AppController
{
    private $contractorsService;

    public function __construct()
    {
        parent::__construct();
        $this->contractorsService = new ContractorsService();
    }

    public function all()
    {
        $data = ["contractors" => $this->contractorsService->getAllContractors()];
        echo json_encode($data, true);
    }
}

