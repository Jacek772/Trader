<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Unit.php";

// Services
require_once __DIR__."/../services/UnitsService.php";

class UnitsInitializer implements IInitializer
{
    private static $unitsData = [
        [
            "symbol" => "SZT"
        ],
        [
            "symbol" => "KPL"
        ],
        [
            "symbol" => "KG"
        ],
        [
            "symbol" => "M"
        ]
    ];

    private $unitsService;

    public function __construct()
    {
        $this->unitsService = new UnitsService();
    }

    public function initialize(): void
    {
        foreach (self::$unitsData as $unitData)
        {
            $unit = new Unit(
                0,
                $unitData["symbol"]
            );
            $this->unitsService->createUnitIfNotExists($unit);
        }

    }
}