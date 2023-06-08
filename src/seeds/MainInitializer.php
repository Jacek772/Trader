<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Initializers
require_once "UsersInitializer.php";
require_once "RolesInitializer.php";
require_once "DocumentdefinitionsInitializer.php";
require_once "AddressesInitializer.php";
require_once "UnitsInitializer.php";
require_once "VatratesInitializer.php";
require_once "WarehousesInitializer.php";
require_once "CommodityInitializer.php";
require_once "ContractorsInitializer.php";
require_once "CurrenciesInitializer.php";
require_once "DocumentsInitializer.php";
require_once "DocumentpositionsInitializer.php";

class MainInitializer implements IInitializer
{
    private $usersInitializer;
    private $rolesInitializer;
    private $documentdefinitionsInitializer;
    private $addressesInitializer;
    private $unitsInitializer;
    private $vatratesInitializer;
    private $warehousesInitializer;
    private $commodityInitializer;
    private $contractorsInitializer;
    private $currenciesInitializer;
    private $documentsInitializer;
    private $documentpositionsInitializer;

    public function __construct()
    {
        $this->usersInitializer = new UsersInitializer();
        $this->rolesInitializer = new RolesInitializer();
        $this->documentdefinitionsInitializer = new DocumentdefinitionsInitializer();
        $this->addressesInitializer = new AddressesInitializer();
        $this->unitsInitializer = new UnitsInitializer();
        $this->vatratesInitializer = new VatratesInitializer();
        $this->warehousesInitializer = new WarehousesInitializer();
        $this->commodityInitializer = new CommodityInitializer();
        $this->contractorsInitializer = new ContractorsInitializer();
        $this->currenciesInitializer = new CurrenciesInitializer();
        $this->documentsInitializer = new DocumentsInitializer();
        $this->documentpositionsInitializer = new DocumentpositionsInitializer();
    }

    public function initialize(): void
    {
        // Kolejność wywołania jest istotna!
        $this->rolesInitializer->initialize();
        $this->usersInitializer->initialize();

        $this->documentdefinitionsInitializer->initialize();

        $this->addressesInitializer->initialize();
        $this->unitsInitializer->initialize();
        $this->vatratesInitializer->initialize();
        $this->warehousesInitializer->initialize();

        $this->commodityInitializer->initialize();
        $this->contractorsInitializer->initialize();
        $this->currenciesInitializer->initialize();

        $this->documentsInitializer->initialize();
        $this->documentpositionsInitializer->initialize();
    }
}