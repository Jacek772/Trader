<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Warehouse.php";

// Services
require_once __DIR__."/../services/WarehousesService.php";
require_once __DIR__."/../services/AddressesService.php";

class WarehousesInitializer implements IInitializer
{
    private static $warehousesData = [
        [
            "symbol" => "01",
            "name" => "Magazyn 01",
            "description" => "Magazyn o symbolu 01",
        ],
        [
            "symbol" => "02",
            "name" => "Magazyn 02",
            "description" => "Magazyn o symbolu 02",
        ],
        [
            "symbol" => "03",
            "name" => "Magazyn 03",
            "description" => "Magazyn o symbolu 03",
        ],
    ];

    private $warehousesService;
    private $addressesService;

    public function __construct()
    {
        $this->warehousesService = new WarehousesService();
        $this->addressesService = new AddressesService();
    }

    public function initialize(): void
    {
        $addresses = $this->addressesService->getFirstAddresses(3);

        $i = 0;
        foreach (self::$warehousesData as $warehouseData)
        {
            $address = $addresses[$i];

            $warehouse = new Warehouse(
              0,
                $warehouseData["symbol"],
                $warehouseData["name"],
                $warehouseData["description"],
                $address->getIdaddress()
            );
            $this->warehousesService->createWarehouseIfNotExists($warehouse);

            if($i < 3)
            {
                $i++;
            }
            else
            {
                $i = 0;
            }
        }
    }
}