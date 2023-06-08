<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Documentposition.php";

class DocumentpositionsRepository extends Repository
{
    public function createDocumentposition(Documentposition $documentposition): void
    {
        $query = "INSERT INTO trader.documentpositions (iddocumentposition, quantity, price, iddocument, idcommodity, idvatrate)
                    VALUES (DEFAULT, :quantity, :price, :iddocument, :idcommodity, :idvatrate)";

        $stmt = $this->databse->connect()->prepare($query);
        $params = array(
            ":quantity" => $documentposition->getQuantity(),
            ":price" => $documentposition->getPrice(),
            ":iddocument" => $documentposition->getIddocument(),
            ":idcommodity" => $documentposition->getIdcommodity(),
            ":idvatrate" => $documentposition->getIdvatrate()
        );
        $stmt->execute($params);
    }

    public function getDocumentposition(int $iddocument, int $idcommodity): ?Documentposition
    {
        $query = "SELECT * FROM trader.documentpositions WHERE iddocument = :iddocument AND idcommodity = :idcommodity LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":iddocument", $iddocument, PDO::PARAM_INT);
        $stmt->bindParam(":idcommodity", $idcommodity, PDO::PARAM_INT);
        $stmt->execute();

        $documentposition = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$documentposition)
        {
            return null;
        }

        return new Documentposition(
            0,
            $documentposition["quantity"],
            $documentposition["price"],
            $documentposition["iddocument"],
            $documentposition["idcommodity"],
            $documentposition["idvatrate"]
        );
    }
}