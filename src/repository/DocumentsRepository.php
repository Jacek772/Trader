<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Document.php";

class DocumentsRepository extends Repository
{
    public function getAllDocuments(): array
    {
        $query = "SELECT * FROM trader.documents";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $documents = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$documents)
        {
            return [];
        }
        return $documents;
    }

    public function createDocument(Document $document): void
    {
        $query = "INSERT INTO trader.documents (iddocument, date, number, state, description, iddocumentdefinition, idcontractor, idwarehouse, idcurrency)
                    VALUES (DEFAULT, :date, :number, :state, :description, :iddocumentdefinition, :idcontractor, :idwarehouse, :idcurrency)";

        $stmt = $this->databse->connect()->prepare($query);
        $params = array(
            ":date" => $document->getDate(),
            ":number" => $document->getNumber(),
            ":state" => $document->getState(),
            ":description" => $document->getDescription(),
            ":iddocumentdefinition" => $document->getIdDefinition(),
            ":idcontractor" => $document->getIdContractor(),
            ":idwarehouse" => $document->getIdWarehouse(),
            ":idcurrency" => $document->getIdCurrency(),
        );
        $stmt->execute($params);
    }

    public function getDocument(string $number): ?Document
    {
        $query = "SELECT * FROM trader.documents WHERE number = :number LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":number", $number, PDO::PARAM_STR);
        $stmt->execute();

        $document = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$document)
        {
            return null;
        }

        return new Document(
            $document["iddocument"],
            $document["date"],
            $document["number"],
            $document["state"],
            $document["description"],
            $document["iddocumentdefinition"],
            $document["idcontractor"],
            $document["idwarehouse"],
            $document["idcurrency"]
        );
    }
}