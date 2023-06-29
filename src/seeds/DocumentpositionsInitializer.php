<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Documentposition.php";

// Services
require_once __DIR__."/../services/DocumentsService.php";
require_once __DIR__."/../services/DocumentpositionsService.php";
require_once __DIR__."/../services/CommodityService.php";
require_once __DIR__."/../services/CurrenciesService.php";
require_once __DIR__."/../services/VatratesService.php";

class DocumentpositionsInitializer implements IInitializer
{
    private $documentsService;
    private $documentpositionsService;
    private $commodityService;
    private $currenciesService;
    private $vatratesService;

    public function __construct()
    {
        $this->documentsService = new DocumentsService();
        $this->documentpositionsService = new DocumentpositionsService();
        $this->commodityService = new CommodityService();
        $this->currenciesService = new CurrenciesService();
        $this->vatratesService = new VatratesService();
    }

    private static $documentpositionsData = [
        [
            "quantity" => 12,
            "price" => 10.0,
            "documentNumber" => "OO/000001/2023/06/1",
            "commoditySymbol" => "PR001",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 5,
            "price" => 12.56,
            "documentNumber" => "OO/000001/2023/06/1",
            "commoditySymbol" => "PR002",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 2,
            "price" => 17.0,
            "documentNumber" => "OO/000001/2023/06/1",
            "commoditySymbol" => "PR003",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 1,
            "price" => 5.99,
            "documentNumber" => "WZ/000001/2023/06/1",
            "commoditySymbol" => "PR001",
            "vatratePercent" => 0.05
        ],
        [
            "quantity" => 10,
            "price" => 17.99,
            "documentNumber" => "WZ/000001/2023/06/1",
            "commoditySymbol" => "PR002",
            "vatratePercent" => 0.08
        ],
        [
            "quantity" => 8,
            "price" => 12.45,
            "documentNumber" => "WZ/000001/2023/06/1",
            "commoditySymbol" => "PR003",
            "vatratePercent" => 0.08
        ],
        [
            "quantity" => 45,
            "price" => 56.88,
            "documentNumber" => "WZ/000001/2023/05/1",
            "commoditySymbol" => "PR003",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 12,
            "price" => 10.0,
            "documentNumber" => "FV/000001/2023/06/1",
            "commoditySymbol" => "PR001",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 5,
            "price" => 12.56,
            "documentNumber" => "FV/000001/2023/06/1",
            "commoditySymbol" => "PR002",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 2,
            "price" => 17.0,
            "documentNumber" => "FV/000001/2023/06/1",
            "commoditySymbol" => "PR003",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 1,
            "price" => 5.99,
            "documentNumber" => "FV/000001/2023/06/2",
            "commoditySymbol" => "PR001",
            "vatratePercent" => 0.05
        ],
        [
            "quantity" => 10,
            "price" => 17.99,
            "documentNumber" => "FV/000001/2023/06/2",
            "commoditySymbol" => "PR002",
            "vatratePercent" => 0.08
        ],
        [
            "quantity" => 1,
            "price" => 5.99,
            "documentNumber" => "PZ/000001/2023/06/1",
            "commoditySymbol" => "PR001",
            "vatratePercent" => 0.23
        ],
        [
            "quantity" => 10,
            "price" => 17.99,
            "documentNumber" => "PZ/000001/2023/06/1",
            "commoditySymbol" => "PR002",
            "vatratePercent" => 0.08
        ],
    ];

    public function initialize(): void
    {
        foreach (self::$documentpositionsData as $documentpositionData)
        {
            $document = $this->documentsService->getDocument($documentpositionData["documentNumber"]);
            $commodity = $this->commodityService->getCommodity($documentpositionData["commoditySymbol"]);
            $vatrate = $this->vatratesService->getVatrate($documentpositionData["vatratePercent"]);

            $documentposition = new Documentposition(
              0,
                $documentpositionData["quantity"],
                $documentpositionData["price"],
                $document->getIddocument(),
                $commodity->getIdcommodity(),
                $vatrate->getIdvatrate()
            );
            $this->documentpositionsService->createDocumentpositionIfNotExists($documentposition);
        }
    }
}