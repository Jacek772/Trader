<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Documentposition.php";
require_once __DIR__."/../models/Commodity.php";

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

    public function getDocumentpositionsByIdDocument(int $iddocument): array
    {
//        $query = "SELECT * FROM trader.documentpositions WHERE iddocument = :iddocument";
        $query = "SELECT dp.iddocumentposition, dp.quantity dp_quantity, dp.price dp_price, dp.iddocument dp_iddocument, dp.idvatrate dp_idvatrate,
                           c.idcommodity, c.symbol c_symbol, c.name c_name, c.description c_description, c.idunit c_idunit, c.idvatrate c_idvatrate,
                           vr.percent vr_percent
                    FROM trader.documentpositions dp
                    INNER JOIN trader.commodities c ON c.idcommodity = dp.idcommodity 
                    INNER JOIN trader.vatrates vr ON vr.idvatrate = dp.idvatrate
                    WHERE iddocument = :iddocument";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":iddocument", $iddocument, PDO::PARAM_INT);
        $stmt->execute();

        $documentpositionsData = $stmt->fetchAll();
        if(!$documentpositionsData)
        {
            return [];
        }

        $documentpositions = [];
        foreach ($documentpositionsData as $documentpositionData)
        {
            $documentposition = new Documentposition(
                $documentpositionData["iddocumentposition"],
                $documentpositionData["dp_quantity"],
                $documentpositionData["dp_price"],
                $documentpositionData["dp_iddocument"],
                $documentpositionData["idcommodity"],
                $documentpositionData["dp_idvatrate"]
            );

            $commodity = new Commodity(
                $documentpositionData["idcommodity"],
                $documentpositionData["c_symbol"],
                $documentpositionData["c_name"],
                $documentpositionData["c_description"],
                $documentpositionData["c_idunit"],
                $documentpositionData["c_idvatrate"]
            );
            $documentposition->setCommodity($commodity);

            $vatrate = new Vatrate(
                $documentpositionData["dp_idvatrate"],
                $documentpositionData["vr_percent"]
            );
            $documentposition->setVatrate($vatrate);

            array_push($documentpositions, $documentposition);
        }
        return $documentpositions;
    }

    public function getDocumentposition(int $iddocument, int $idcommodity): ?Documentposition
    {
        $query = "SELECT * FROM trader.documentpositions WHERE iddocument = :iddocument AND idcommodity = :idcommodity LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":iddocument", $iddocument, PDO::PARAM_INT);
        $stmt->bindParam(":idcommodity", $idcommodity, PDO::PARAM_INT);
        $stmt->execute();

        $documentpositionData = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$documentpositionData)
        {
            return null;
        }

        return new Documentposition(
            $documentpositionData["iddocumentposition"],
            $documentpositionData["quantity"],
            $documentpositionData["price"],
            $documentpositionData["iddocument"],
            $documentpositionData["idcommodity"],
            $documentpositionData["idvatrate"]
        );
    }

    public function deleteDocumentpositions(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.documentpositions WHERE iddocumentposition IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }
}