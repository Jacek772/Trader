<?php

require_once "Repository.php";

// Models
require_once __DIR__."/../models/Warehouse.php";

class WarehousesRepository extends Repository
{
    public function getAllWarehouses(): array
    {
        $query = "SELECT * FROM trader.warehouses";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $warehousesData = $stmt->fetchAll();
        if(!$warehousesData)
        {
            return [];
        }

        $warehouses = [];
        foreach ($warehousesData as $warehouseData)
        {
            $warehouse = new Warehouse(
                $warehouseData["idwarehouse"],
                $warehouseData["symbol"],
                $warehouseData["name"],
                $warehouseData["description"],
                $warehouseData["idaddress"]
            );

            array_push($warehouses, $warehouse);
        }
        return $warehouses;
    }

    public function getWarehouse(string $symbol): ?Warehouse
    {
        $query = "SELECT * FROM trader.warehouses WHERE symbol = :symbol LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();

        $warehouse = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$warehouse)
        {
            return null;
        }

        return new Warehouse(
            $warehouse["idwarehouse"],
            $warehouse["symbol"],
            $warehouse["name"],
            $warehouse["description"],
            $warehouse["idaddress"]
        );
    }

    public function createWarehouse(Warehouse $warehouse): void
    {
        $query = "INSERT INTO trader.warehouses VALUES (DEFAULT, :symbol, :name, :description, :idaddress)";

        $symbol = $warehouse->getSymbol();
        $name = $warehouse->getName();
        $description = $warehouse->getDescription();
        $idaddress = $warehouse->getIdaddress();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":idaddress", $idaddress, PDO::PARAM_INT);
        $stmt->execute();
    }
}