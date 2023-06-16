<?php


//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/CurrenciesService.php";

// Models
require_once __DIR__."/../models/Currency.php";

class CurrenciesController extends AppController
{
    private $currenciesService;

    public function __construct()
    {
        parent::__construct();
        $this->currenciesService = new CurrenciesService();
    }

    public function all()
    {
        $data = ["currencies" => $this->currenciesService->getAllCurrencies()];
        echo json_encode($data, true);
    }
}