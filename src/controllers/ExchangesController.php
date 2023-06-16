<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/ExchangesService.php";

class ExchangesController extends AppController
{
    private $exchangesService;

    public function __construct()
    {
        parent::__construct();
        $this->exchangesService = new ExchangesService();
    }

    public function all()
    {
        $data = ["exchanges" => $this->exchangesService->getAllExchanges()];
        echo json_encode($data, true);
    }

    public function fetchExchangesAndSave()
    {
        try {
            $days = $_POST["days"];
            $this->exchangesService->fetchExchangesAndSave($days);
            header("HTTP/1.1 200 OK");
        }
        catch (Exception $e)
        {
            echo $e;
            header('HTTP/1.1 500 Internal Server Error');
        }
    }

}