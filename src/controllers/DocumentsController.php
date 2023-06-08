<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/DocumentsService.php";

class DocumentsController extends AppController
{
    private $documentsService;

    public function __construct()
    {
        parent::__construct();
        $this->documentsService = new DocumentsService();
    }

    public function all()
    {
        $data = ["documents" => $this->documentsService->getAllDocuments()];
        echo json_encode($data);
    }


}