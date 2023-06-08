<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Commodity.php";

class CommodityRepository extends Repository
{
    public function getCommodity(string $symbol): ?Commodity
    {
        $query = "SELECT * FROM trader.commodities WHERE symbol = :symbol LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();

        $commodity = $stmt->fetch(PDO::FETCH_ASSOC);
        if($commodity == false)
        {
            return null;
        }
        return new Commodity(
            $commodity["idcommodity"],
            $commodity["symbol"],
            $commodity["name"],
            $commodity["description"],
            $commodity["idunit"],
            $commodity["idvatrate"]
        );
    }

    public function createCommodity(Commodity $commodity): void
    {
        $query = "INSERT INTO trader.commodities VALUES (DEFAULT, :symbol, :name, :description, :idunit, :idvatrate)";

        $symbol = $commodity->getSymbol();
        $name = $commodity->getName();
        $description = $commodity->getDescription();
        $idunit = $commodity->getIdunit();
        $idvatrate = $commodity->getIdvatrate();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":idunit", $idunit, PDO::PARAM_INT);
        $stmt->bindParam(":idvatrate", $idvatrate, PDO::PARAM_INT);
        $stmt->execute();
    }
}