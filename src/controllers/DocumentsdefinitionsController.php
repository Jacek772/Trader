<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/DocumentdefinitionsService.php";

class DocumentsdefinitionsController extends AppController
{
    private $documentdefinitionsService;

    public function __construct()
    {
        parent::__construct();
        $this->documentdefinitionsService = new DocumentdefinitionsService();
    }

    public function all()
    {
        try {
            $data = ["documentsdefinitions" => $this->documentdefinitionsService->getAllDocumentsdefinitions()];
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
            $name = $_POST["name"];
            $symbol = $_POST["symbol"];
            $direction = $_POST["direction"];
            $type = $_POST["type"];
            $description = $_POST["description"];

            $documentdefinition = new Documentdefinition(
                0,
                $name,
                $symbol,
                $direction,
                $type,
                $description
            );

            $this->documentdefinitionsService->createDocumentdefinition($documentdefinition);
        }
        catch (Exception $e)
        {
            eader("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {
            $iddocumentdefinition = $_POST["iddocumentdefinition"];
            $documentdefinitionData = [
                "name" => $_POST["name"],
                "symbol" => $_POST["symbol"],
                "direction" => $_POST["direction"],
                "type" => $_POST["type"],
                "description" => $_POST["description"]
            ];

            $this->documentdefinitionsService->updateDocumentdefinition($iddocumentdefinition, $documentdefinitionData);
        }
        catch (Exception $e)
        {
            eader("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function remove()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split ("/\,/", $idsStr);
            $this->documentdefinitionsService->deleteDocumentdefinitions($ids);
        }
        catch (Exception $e)
        {
            eader("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }
}