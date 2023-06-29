<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/DocumentpositionsService.php";

class DocumentspositionsController extends AppController
{
    private $documentpositionsService;

    public function __construct()
    {
        parent::__construct();
        $this->documentpositionsService = new DocumentpositionsService();
    }

    public function create()
    {
        try {
            $documentposition = new Documentposition(
                0,
                $_POST["quantity"],
                $_POST["price"],
                $_POST["iddocument"],
                $_POST["idcommodity"],
                $_POST["idvatrate"],
            );
            $this->documentpositionsService->createDocumentposition($documentposition);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function remove()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split ("/\,/", $idsStr);
            $this->documentpositionsService->deleteDocumentpositions($ids);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()], true) ;
        }
    }
}