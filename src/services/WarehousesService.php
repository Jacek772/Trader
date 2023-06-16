<?php

// Repositories
require_once __DIR__."/../repository/WarehousesRepository.php";

// Models
require_once __DIR__."/../models/Warehouse.php";

class WarehousesService
{
    private $warehousesRepository;

    public function __construct()
    {
        $this->warehousesRepository = new WarehousesRepository();
    }

    public function createWarehouseIfNotExists(Warehouse $warehouse): void
    {
        if(!$this->existsWarehouse($warehouse->getSymbol()))
        {
            $this->createWarehouse($warehouse);
        }
    }

    public function getAllWarehouses(): array
    {
        return $this->warehousesRepository->getAllWarehouses();
    }

    public function getWarehouse(string $symbol): ?Warehouse
    {
        return $this->warehousesRepository->getWarehouse($symbol);
    }

    public function createWarehouse(Warehouse $warehouse): void
    {
        $this->warehousesRepository->createWarehouse($warehouse);
    }

    public function existsWarehouse(string $symbol): bool
    {
        if(!$symbol)
        {
            return false;
        }

        $warehouse = $this->getWarehouse($symbol);
        return $warehouse != null;
    }
}