<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/DocumentdefinitionsService.php";

class DocumentsdefinitionsController extends AppController
{
    private $documentpositionsService;

    public function __construct()
    {
        parent::__construct();
        $this->documentpositionsService = new DocumentdefinitionsService();
    }

    public function all()
    {
        $data = ["documentsdefinitions" => $this->documentpositionsService->getAllDocumentsdefinitions()];
        echo json_encode($data, true);
    }
}