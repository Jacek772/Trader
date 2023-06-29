<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Document.php";

// DTO
require_once __DIR__."/../dtos/DocumentDTO.php";

class DocumentsRepository extends Repository
{
    public function getDocuments(?string $periodFrom = null, ?string $periodTo = null, ?int $idDefinition = null,
                                 ?int $idContractor = null, ?int $idWarehouse = null, ?int $type = null)  : array
    {
        $query = "SELECT d.iddocument, d.date d_date, d.number d_number, d.state d_state, d.description d_description,
            dd.iddocumentdefinition, dd.name dd_name, dd.symbol dd_symbol, dd.description dd_description, dd.direction dd_direction, dd.type dd_type,
            c.idcurrency, c.name c_name, c.symbol c_symbol,
            co.idcontractor, co.companyname co_companyname, co.nip co_nip, co.pesel co_pesel,
            w.idwarehouse, w.symbol w_symbol, w.name w_name, w.description w_description
            FROM trader.documents d
            INNER JOIN trader.documentdefinitions dd ON dd.iddocumentdefinition = d.iddocumentdefinition
            INNER JOIN trader.currencies c ON c.idcurrency = d.idcurrency
            INNER JOIN trader.contractors co on co.idcontractor = d.idcontractor
            INNER JOIN trader.warehouses w ON w.idwarehouse = d.idwarehouse";

        $queryParts = [];
        $filters = [];

        if($periodFrom)
        {
            array_push($queryParts, "d.date >= ?");
            array_push($filters, $periodFrom);
        }

        if($periodTo)
        {
            array_push($queryParts, "d.date <= ?");
            array_push($filters, $periodTo);
        }

        if($idDefinition)
        {
            array_push($queryParts, "dd.iddocumentdefinition = ?");
            array_push($filters, $idDefinition);
        }

        if($idContractor)
        {
            array_push($queryParts, "co.idcontractor = ?");
            array_push($filters, $idContractor);
        }

        if($idWarehouse)
        {
            array_push($queryParts, "w.idwarehouse = ?");
            array_push($filters, $idWarehouse);
        }

        if($type)
        {
            array_push($queryParts, "dd.type = ?");
            array_push($filters, $type);
        }

        if(count($filters) > 0)
        {
            $query = $query." WHERE ".join(" AND ", $queryParts);
        }

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($filters);
        $documentsData = $stmt->fetchAll();
        if(!$documentsData)
        {
            return [];
        }

        $documents = [];
        foreach ($documentsData as $documentData)
        {
            $document = new Document(
                $documentData["iddocument"],
                $documentData["d_date"],
                $documentData["d_number"],
                $documentData["d_state"],
                $documentData["d_description"],
                $documentData["iddocumentdefinition"],
                $documentData["idcontractor"],
                $documentData["idwarehouse"],
                $documentData["idcurrency"]
            );

            $documentdefinition = new Documentdefinition(
                $documentData["iddocumentdefinition"],
                $documentData["dd_name"],
                $documentData["dd_symbol"],
                $documentData["dd_direction"],
                $documentData["dd_type"],
                $documentData["dd_description"],
            );
            $document->setDefinition($documentdefinition);

            $currency = new Currency(
                $documentData["idcurrency"],
                $documentData["c_symbol"],
                $documentData["c_name"]
            );
            $document->setCurrency($currency);

            $contractor = new Contractor(
                $documentData["idcontractor"],
                $documentData["co_companyname"],
                $documentData["co_nip"],
                $documentData["co_pesel"],
                0,
                0
            );
            $document->setContractor($contractor);

            $warehouse = new Warehouse(
                $documentData["idwarehouse"],
                $documentData["w_symbol"],
                $documentData["w_name"],
                $documentData["w_description"],
                0
            );
            $document->setWarehouse($warehouse);

            array_push($documents, $document);
        }
        return $documents;
    }

    public function getAllDocuments(): array
    {
        $query = "SELECT d.iddocument, d.date d_date, d.number d_number, d.state d_state, d.description d_description,
            dd.iddocumentdefinition, dd.name dd_name, dd.symbol dd_symbol, dd.description dd_description, dd.direction dd_direction, dd.type dd_type,
            c.idcurrency, c.name c_name, c.symbol c_symbol,
            co.idcontractor, co.companyname co_companyname, co.nip co_nip, co.pesel co_pesel,
            w.idwarehouse, w.symbol w_symbol, w.name w_name, w.description w_description
            FROM trader.documents d
            INNER JOIN trader.documentdefinitions dd ON dd.iddocumentdefinition = d.iddocumentdefinition
            INNER JOIN trader.currencies c ON c.idcurrency = d.idcurrency
            INNER JOIN trader.contractors co on co.idcontractor = d.idcontractor
            INNER JOIN trader.warehouses w ON w.idwarehouse = d.idwarehouse";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $documentsData = $stmt->fetchAll();
        if(!$documentsData)
        {
            return [];
        }

        $documents = [];
        foreach ($documentsData as $documentData)
        {
            $document = new Document(
                $documentData["iddocument"],
                $documentData["d_date"],
                $documentData["d_number"],
                $documentData["d_state"],
                $documentData["d_description"],
                $documentData["iddocumentdefinition"],
                $documentData["idcontractor"],
                $documentData["idwarehouse"],
                $documentData["idcurrency"]
            );

            $documentdefinition = new Documentdefinition(
                $documentData["iddocumentdefinition"],
                $documentData["dd_name"],
                $documentData["dd_symbol"],
                $documentData["dd_direction"],
                $documentData["dd_type"],
                $documentData["dd_description"],
            );
            $document->setDefinition($documentdefinition);

            $currency = new Currency(
                $documentData["idcurrency"],
                $documentData["c_symbol"],
                $documentData["c_name"]
            );
            $document->setCurrency($currency);

            $contractor = new Contractor(
                $documentData["idcontractor"],
                $documentData["co_companyname"],
                $documentData["co_nip"],
                $documentData["co_pesel"],
                0,
                0
            );
            $document->setContractor($contractor);

            $warehouse = new Warehouse(
                $documentData["idwarehouse"],
                $documentData["w_symbol"],
                $documentData["w_name"],
                $documentData["w_description"],
                0
            );
            $document->setWarehouse($warehouse);

            array_push($documents, $document);
        }
        return $documents;
    }

    public function updateDocument(int $iddocument,  array $documentData): void
    {
        $columnNames = array();
        $params = array();
        $params[":iddocument"] = $iddocument;

        if(isset($documentData["idcontractor"]))
        {
            $params[":idcontractor"] = $documentData["idcontractor"];
            array_push($columnNames, "idcontractor = :idcontractor");
        }

        if(isset($documentData["date"]))
        {
            $params[":date"] = $documentData["date"];
            array_push($columnNames, "date = :date");
        }

        if(isset($documentData["state"]))
        {
            $params[":state"] = $documentData["state"];
            array_push($columnNames, "state = :state");
        }

        if(isset($documentData["description"]))
        {
            $params[":description"] = $documentData["description"];
            array_push($columnNames, "description = :description");
        }

        if(isset($documentData["idwarehouse"]))
        {
            $params[":idwarehouse"] = $documentData["idwarehouse"];
            array_push($columnNames, "idwarehouse = :idwarehouse");
        }

        if(isset($documentData["idcurrency"]))
        {
            $params[":idcurrency"] = $documentData["idcurrency"];
            array_push($columnNames, "idcurrency = :idcurrency");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.documents SET ".$columnNamesStr." WHERE iddocument = :iddocument";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
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
            ":iddocumentdefinition" => $document->getIddefinition(),
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

    public function deleteDocuments(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.documents WHERE iddocument IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }
}