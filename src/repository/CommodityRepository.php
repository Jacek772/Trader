<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Commodity.php";
require_once __DIR__."/../models/Unit.php";
require_once __DIR__."/../models/Vatrate.php";

class CommodityRepository extends Repository
{
    public function getAllCommodities(): array
    {
        $query = "SELECT c.idcommodity, c.symbol c_symbol, c.name c_name, c.description c_description,
                           u.idunit, u.symbol u_symbol, u.name u_name,
                           vr.idvatrate, vr.percent vr_percent
                    FROM trader.commodities c
                    INNER JOIN trader.units u ON u.idunit = c.idunit
                    INNER JOIN trader.vatrates vr ON vr.idvatrate = c.idvatrate";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $commoditiesData = $stmt->fetchAll();
        if(!$commoditiesData)
        {
            return [];
        }

        $commodities = [];
        foreach ($commoditiesData as $commodityData)
        {
            $commodity = new Commodity(
                $commodityData["idcommodity"],
                $commodityData["c_symbol"],
                $commodityData["c_name"],
                $commodityData["c_description"],
                $commodityData["idunit"],
                $commodityData["idvatrate"],
            );

            $unit = new Unit(
                $commodityData["idunit"],
                $commodityData["u_symbol"]
            );
            $commodity->setUnit($unit);

            $vatrate = new Vatrate(
                $commodityData["idvatrate"],
                $commodityData["vr_percent"]
            );
            $commodity->setVatrate($vatrate);

            array_push($commodities, $commodity);
        }

        return $commodities;
    }

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

    public function deleteCommodities($ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.commodities WHERE idcommodity IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }

    public function updateCommodity(int $idcommodity, array $commodityData): void
    {
        $columnNames = array();
        $params = array();
        $params[":idcommodity"] = $idcommodity;

        if(isset($commodityData["symbol"]))
        {
            $params[":symbol"] = $commodityData["symbol"];
            array_push($columnNames, "symbol = :symbol");
        }

        if(isset($commodityData["name"]))
        {
            $params[":name"] = $commodityData["name"];
            array_push($columnNames, "name = :name");
        }

        if(isset($commodityData["description"]))
        {
            $params[":description"] = $commodityData["description"];
            array_push($columnNames, "description = :description");
        }

        if(isset($commodityData["idunit"]))
        {
            $params[":idunit"] = $commodityData["idunit"];
            array_push($columnNames, "idunit = :idunit");
        }

        if(isset($commodityData["idvatrate"]))
        {
            $params[":idvatrate"] = $commodityData["idvatrate"];
            array_push($columnNames, "idvatrate = :idvatrate");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.commodities SET ".$columnNamesStr." WHERE idcommodity = :idcommodity";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
    }
}