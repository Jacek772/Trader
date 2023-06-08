<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Commodity.php";

// Services
require_once __DIR__."/../services/CommodityService.php";

class CommodityInitializer implements IInitializer
{
    private static $commoditiesData = [
        [
            "symbol" => "PR001",
            "name" => "Produkt 1",
            "description" => "Opis produktu 1",
            "unitSymbol" => "SZT",
            "vatratePercent" => 0.23
        ],
        [
            "symbol" => "PR002",
            "name" => "Produkt 2",
            "description" => "Opis produktu 2",
            "unitSymbol" => "SZT",
            "vatratePercent" => 0.05
        ],
        [
            "symbol" => "PR003",
            "name" => "Produkt 3",
            "description" => "Opis produktu 3",
            "unitSymbol" => "SZT",
            "vatratePercent" => 0.08
        ],
        [
            "symbol" => "PR004",
            "name" => "Produkt 4",
            "description" => "Opis produktu 4",
            "unitSymbol" => "KPL",
            "vatratePercent" => 0.23
        ],
        [
            "symbol" => "PR005",
            "name" => "Produkt 5",
            "description" => "Opis produktu 5",
            "unitSymbol" => "KG",
            "vatratePercent" => 0.08
        ],
    ];

    private $commodityService;
    private $unitsService;
    private $vatratesService;

    public function __construct()
    {
        $this->commodityService = new CommodityService();
        $this->unitsService = new UnitsService();
        $this->vatratesService = new VatratesService();
    }

    public function initialize(): void
    {
        foreach (self::$commoditiesData as $commodityData)
        {
            $unit = $this->unitsService->getUnit($commodityData["unitSymbol"]);
            $vatRate = $this->vatratesService->getVatrate($commodityData["vatratePercent"]);

            $commodity = new Commodity(
                0,
                $commodityData["symbol"],
                $commodityData["name"],
                $commodityData["description"],
                $unit->getIdunit(),
                $vatRate->getIdvatrate()
            );
            $this->commodityService->createCommodityIfNotExists($commodity);
        }
    }
}