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
        $periodFrom = $_GET["periodFrom"];
        $periodTo = $_GET["periodTo"];
        $definition = $_GET["definition"];
        $contractor = $_GET["contractor"];
        $warehouse = $_GET["warehouse"];

        $data = ["documents" => $this->documentsService->getDocuments($periodFrom, $periodTo, $definition, $contractor, $warehouse)];
        echo json_encode($data, true);
    }

    public function delete()
    {
        $idsStr = $_POST["ids"];
        $ids = preg_split ("/\,/", $idsStr);
        $this->documentsService->deleteDocuments($ids);
    }
}

