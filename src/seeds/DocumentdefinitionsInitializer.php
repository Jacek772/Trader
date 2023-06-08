<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Documentdefinition.php";

// Services
require_once __DIR__."/../services/DocumentdefinitionsService.php";

// Enums
require_once __DIR__."/../models/enums/DocumentDirection.php";
require_once __DIR__."/../models/enums/DocumentType.php";

class DocumentdefinitionsInitializer implements IInitializer
{
    private static $documentdefinitionsData = [
        [
            "name" => "Oferta odbiorcy",
            "symbol" => "OO",
            "direction" => DocumentDirection::NO,
            "type" => DocumentType::OFFER,
            "description" => "Ofert for customer",
        ],
        [
            "name" => "Wydanie zewnętrzne",
            "symbol" => "WZ",
            "direction" => DocumentDirection::EXPEDITURE,
            "type" => DocumentType::WAREHOUSE,
            "description" => "",
        ],
        [
            "name" => "Przyjęcie zewnętrzne",
            "symbol" => "PZ",
            "direction" => DocumentDirection::INCOME,
            "type" => DocumentType::WAREHOUSE,
            "description" => "",
        ],
        [
            "name" => "Faktura VAT",
            "symbol" => "FV",
            "direction" => DocumentDirection::NO,
            "type" => DocumentType::SALE,
            "description" => "",
        ],
    ];

    private $documentdefinitionsService;

    public function __construct()
    {
        $this->documentdefinitionsService = new DocumentdefinitionsService();
    }

    public function initialize(): void
    {
        foreach (self::$documentdefinitionsData as $documentdefinitionData)
        {
            $documentdefinition = new Documentdefinition(
                0,
                $documentdefinitionData["name"],
                $documentdefinitionData["symbol"],
                $documentdefinitionData["direction"],
                $documentdefinitionData["type"],
                $documentdefinitionData["description"]
            );
            $this->documentdefinitionsService->createDocumentdefinitionIfNotExists($documentdefinition);
        }
    }
}