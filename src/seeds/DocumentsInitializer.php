<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Document.php";

// Services
require_once __DIR__."/../services/DocumentsService.php";
require_once __DIR__."/../services/DocumentdefinitionsService.php";
require_once __DIR__."/../services/WarehousesService.php";
require_once __DIR__."/../services/CurrenciesService.php";
require_once __DIR__."/../services/ContractorsService.php";

// Enums
require_once __DIR__."/../models/enums/DocumentState.php";

class DocumentsInitializer implements IInitializer
{
    private $documentsService;
    private $documentdefinitionsService;
    private $warehousesService;
    private $currenciesService;
    private $contractorsService;

    public function __construct()
    {
        $this->documentsService = new DocumentsService();
        $this->documentdefinitionsService = new DocumentdefinitionsService();
        $this->warehousesService = new WarehousesService();
        $this->currenciesService = new CurrenciesService();
        $this->contractorsService = new ContractorsService();
    }

    private static $documentsData = [
        [
            "date" => "2023-06-06",
            "number" => "OO/000001/2023/06/1",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument OO utworzony do celów testowych",
            "documentdefinitionSymbol" => "OO",
            "contractorName" => "Firma 1",
            "warehouseSymbol" => "01",
            "currencySymbol" => "PLN"
        ],
        [
            "date" => "2023-06-06",
            "number" => "WZ/000001/2023/06/1",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument WZ utworzony do celów testowych",
            "documentdefinitionSymbol" => "WZ",
            "contractorName" => "Firma 1",
            "warehouseSymbol" => "01",
            "currencySymbol" => "PLN"
        ],
        [
            "date" => "2023-05-06",
            "number" => "WZ/000001/2023/05/1",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument WZ utworzony do celów testowych",
            "documentdefinitionSymbol" => "WZ",
            "contractorName" => "Firma 2",
            "warehouseSymbol" => "02",
            "currencySymbol" => "PLN"
        ],
        [
            "date" => "2023-06-06",
            "number" => "FV/000001/2023/06/1",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument FV utworzony do celów testowych",
            "documentdefinitionSymbol" => "FV",
            "contractorName" => "Firma 2",
            "warehouseSymbol" => "01",
            "currencySymbol" => "PLN"
        ],
        [
            "date" => "2023-06-05",
            "number" => "FV/000001/2023/06/2",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument FV utworzony do celów testowych",
            "documentdefinitionSymbol" => "FV",
            "contractorName" => "Firma 1",
            "warehouseSymbol" => "01",
            "currencySymbol" => "EUR"
        ],
        [
            "date" => "2023-06-05",
            "number" => "PZ/000001/2023/06/1",
            "state" => DocumentState::APPROVED,
            "description" => "Dokument PZ utworzony do celów testowych",
            "documentdefinitionSymbol" => "PZ",
            "contractorName" => "Firma 1",
            "warehouseSymbol" => "01",
            "currencySymbol" => "PLN"
        ]
    ];

    public function initialize(): void
    {
        foreach (self::$documentsData as $documentData)
        {
            $documentdefinition = $this->documentdefinitionsService->getDocumentdefinition($documentData["documentdefinitionSymbol"]);
            $contractor = $this->contractorsService->getContractor($documentData["contractorName"]);
            $warehouse = $this->warehousesService->getWarehouse($documentData["warehouseSymbol"]);
            $currency = $this->currenciesService->getCurrency($documentData["currencySymbol"]);

            $document = new Document(
                0,
                $documentData["date"],
                $documentData["number"],
                $documentData["state"],
                $documentData["description"],
                $documentdefinition->getIdDocumentdefinition(),
                $contractor->getIdcontractor(),
                $warehouse->getIdwarehouse(),
                $currency->getIdcurrency()
            );
            $this->documentsService->createDocumentIfNotExist($document);
        }
    }
}