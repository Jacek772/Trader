<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/CommodityService.php";

class CommoditiesController extends AppController
{
    private $commodityService;

    public function __construct()
    {
        parent::__construct();
        $this->commodityService = new CommodityService();
    }

    public function all()
    {
        try {
            $data = ["commodities" => $this->commodityService->getAllCommodities()];
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
            $commodity = new Commodity(
                0,
                $_POST["symbol"],
                $_POST["name"],
                $_POST["description"],
                $_POST["idunit"],
                $_POST["idvatrate"]
            );

            $this->commodityService->createCommodity($commodity);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true);
        }
    }

    public function remove()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split("/\,/", $idsStr);
            $this->commodityService->deleteCommodities($ids);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true);
        }
    }

    public function update()
    {
        try {
            $idcommodity = $_POST["idcommodity"];
            $commodityData = [
                "symbol" => $_POST["symbol"],
                "name" => $_POST["name"],
                "description" => $_POST["description"],
                "idunit" => $_POST["idunit"],
                "idvatrate" => $_POST["idvatrate"],
            ];

            $this->commodityService->updateCommodity($idcommodity, $commodityData);

        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true);
        }
    }
}