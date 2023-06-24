<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/VatratesService.php";

class VatratesController extends AppController
{
    private $vatratesService;

    public function __construct()
    {
        parent::__construct();
        $this->vatratesService = new VatratesService();
    }

    public function all()
    {
        try {
            $data = ["vatrates" => $this->vatratesService->getAllVatrates()];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }
}