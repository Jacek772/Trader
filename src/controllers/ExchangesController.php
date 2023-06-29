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
        try {
            $periodFrom = $_GET["periodFrom"];
            $periodTo = $_GET["periodTo"];
            $idCurrency = $_GET["idCurrency"];

            $data = ["exchanges" => $this->exchangesService->getExchanges($periodFrom, $periodTo, $idCurrency)];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header('HTTP/1.1 500 Internal Server Error');
            echo $e;
        }
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
            header('HTTP/1.1 500 Internal Server Error');
            echo $e;
        }
    }

}