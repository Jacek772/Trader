<?php

class DocumentdefinitionsRepository extends Repository
{
    public function getAllDocumentsdefinitions(): array
    {
        $query = "SELECT * FROM trader.documentdefinitions";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $documentsdefinitionsData = $stmt->fetchAll();
        if(!$documentsdefinitionsData)
        {
            return [];
        }

        $documentsdefinitions = [];
        foreach ($documentsdefinitionsData as $documentdefinitionData)
        {
            $documentdefinition = new Documentdefinition(
                $documentdefinitionData["iddocumentdefinition"],
                $documentdefinitionData["name"],
                $documentdefinitionData["symbol"],
                $documentdefinitionData["direction"],
                $documentdefinitionData["type"],
                $documentdefinitionData["description"]
            );

            array_push($documentsdefinitions, $documentdefinition);
        }
        return $documentsdefinitions;
    }

    public function getDocumentdefinition(string $symbol) : ?Documentdefinition
    {
        $query = "SELECT * FROM trader.documentdefinitions WHERE symbol = :symbol";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();

        $documentdefinition = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$documentdefinition)
        {
            return null;
        }

        return new Documentdefinition(
            $documentdefinition["iddocumentdefinition"],
            $documentdefinition["name"],
            $documentdefinition["symbol"],
            $documentdefinition["direction"],
            $documentdefinition["type"],
            $documentdefinition["description"]
        );
    }

    public function createDocumentdefinition(Documentdefinition $documentdefinition): void
    {
        $query = "INSERT INTO trader.documentdefinitions VALUES (DEFAULT, :name, :symbol, :direction, :type, :description)";

        $name = $documentdefinition->getName();
        $symbol = $documentdefinition->getSymbol();
        $direction = $documentdefinition->getDirection();
        $type = $documentdefinition->getType();
        $description = $documentdefinition->getDescription();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":direction", $direction, PDO::PARAM_INT);
        $stmt->bindParam(":type", $type, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updateDocumentdefinition(int $iddocumentdefinition, array $documentdefinitionData)
    {
        $columnNames = array();
        $params = array();
        $params[":iddocumentdefinition"] = $iddocumentdefinition;

        if(isset($documentdefinitionData["symbol"]))
        {
            $params[":symbol"] = $documentdefinitionData["symbol"];
            array_push($columnNames, "symbol = :symbol");
        }

        if(isset($documentdefinitionData["name"]))
        {
            $params[":name"] = $documentdefinitionData["name"];
            array_push($columnNames, "name = :name");
        }

        if(isset($documentdefinitionData["direction"]))
        {
            $params[":direction"] = $documentdefinitionData["direction"];
            array_push($columnNames, "direction = :direction");
        }

        if(isset($documentdefinitionData["type"]))
        {
            $params[":type"] = $documentdefinitionData["type"];
            array_push($columnNames, "type = :type");
        }

        if(isset($documentdefinitionData["description"]))
        {
            $params[":description"] = $documentdefinitionData["description"];
            array_push($columnNames, "description = :description");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.documentdefinitions SET ".$columnNamesStr." WHERE iddocumentdefinition = :iddocumentdefinition";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
    }

    public function deleteDocumentdefinitions(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.documentdefinitions WHERE iddocumentdefinition IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }
}