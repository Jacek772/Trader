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
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->bindParam(":direction", $direction, PDO::PARAM_INT);
        $stmt->bindParam(":type", $type, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();

    }
}