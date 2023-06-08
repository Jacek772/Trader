<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Vatrate.php";

// Services
require_once __DIR__."/../services/VatratesService.php";

class VatratesInitializer implements IInitializer
{
    private static $vatratesData = [
        [
            "percent" => 0.0
        ],
        [
            "percent" => 0.05,
        ],
        [
            "percent" => 0.08,
        ],
        [
            "percent" => 0.23,
        ],
    ];

    private $vatratesService;

    public function __construct()
    {
        $this->vatratesService = new VatratesService();
    }

    public function initialize(): void
    {
        foreach (self::$vatratesData as $vatrateData)
        {
            $vatrate = new Vatrate(
                0,
                $vatrateData["percent"]
            );
            $this->vatratesService->createVatrateIfNotExists($vatrate);
        }
    }
}