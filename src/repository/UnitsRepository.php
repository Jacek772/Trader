<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Unit.php";

class UnitsRepository extends Repository
{
    public function getAllUnits(): array
    {
        $query = "SELECT * FROM trader.units";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $unitsData = $stmt->fetchAll();
        if(!$unitsData)
        {
            return [];
        }

        $units = [];
        foreach ($unitsData as $unitData)
        {
            $unit = new Unit(
                $unitData["idunit"],
                $unitData["symbol"]
            );

            array_push($units, $unit);
        }
        return $units;
    }

    public function getUnit(string $symbol): ?Unit
    {
        $query = "SELECT * FROM trader.units WHERE symbol = :symbol LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();

        $unit = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$unit)
        {
            return null;
        }
        return new Unit(
            $unit["idunit"],
            $unit["symbol"]
        );
    }

    public function createUnit(Unit $unit): void
    {
        $query = "INSERT INTO trader.units VALUES (DEFAULT, :symbol)";

        $symbol = $unit->getSymbol();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();
    }
}