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
        try {
            $periodFrom = $_GET["periodFrom"];
            $periodTo = $_GET["periodTo"];
            $definition = $_GET["definition"];
            $contractor = $_GET["contractor"];
            $warehouse = $_GET["warehouse"];
            $type = $_GET["type"];

            $data = ["documents" => $this->documentsService->getDocuments($periodFrom, $periodTo, $definition, $contractor, $warehouse, $type)];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true) ;
        }
    }

    public function create()
    {
        try {

        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true) ;
        }
    }

    public function update()
    {
        try {
            $iddocument = $_POST["iddocument"];
            $documentData = [
                "idcontractor" => $_POST["idcontractor"],
                "date" => $_POST["date"],
                "state" => $_POST["state"],
                "description" => $_POST["description"],
                "idwarehouse" => $_POST["idwarehouse"],
                "idcurrency" => $_POST["idcurrency"]
            ];

            $this->documentsService->updateDocument($iddocument, $documentData);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true) ;
        }
    }

    public function delete()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split ("/\,/", $idsStr);
            $this->documentsService->deleteDocuments($ids);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true) ;
        }
    }
}

