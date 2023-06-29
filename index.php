<?php

require_once "Routing.php";
require_once "src/seeds/MainInitializer.php";

//
// Session
//

session_start();

//
// Seeds
//

//$initializeData = true;
$initializeData = false;
if($initializeData)
{
    $mainInitializer = new MainInitializer();
    $mainInitializer->initialize();
}

//
// Controllers
//

$path = trim($_SERVER["REQUEST_URI"], "/");
$path = parse_url($path, PHP_URL_PATH);

// DefaultController - views
Routing::get("", "index", "DefaultController");
Routing::get("home", "home", "DefaultController");
Routing::get("documents", "documents", "DefaultController");
Routing::get("documents/all", "documentsAll", "DefaultController");
Routing::get("documents/orders", "documentsOrders", "DefaultController");
Routing::get("documents/sale", "documentsInvoices", "DefaultController");
Routing::get("documents/offers", "documentsOffers", "DefaultController");
Routing::get("contractors", "contractors", "DefaultController");
Routing::get("commodities", "commodities", "DefaultController");
Routing::get("exchanges", "exchanges", "DefaultController");
Routing::get("settings", "settings", "DefaultController");
Routing::get("settings/main", "settingsMain", "DefaultController");
Routing::get("settings/documentsdefinitions", "settingsDocumentsdefinitions", "DefaultController");
Routing::get("settings/account", "settingsAccount", "DefaultController");
Routing::get("settings/users", "settingsUsers", "DefaultController");

// AuthController
Routing::post("api/auth/login", "login", "AuthController");
Routing::post("api/auth/logout", "logout", "AuthController");

// DocumentsdefinitionsController
Routing::get("api/documentsdefinitions", "all", "DocumentsdefinitionsController");
Routing::post("api/documentsdefinitions", "create", "DocumentsdefinitionsController");
Routing::post("api/documentsdefinitions/delete", "remove", "DocumentsdefinitionsController");
Routing::post("api/documentsdefinitions/update", "update", "DocumentsdefinitionsController");

//DocumentsController
Routing::get("api/documents", "all", "DocumentsController");
Routing::post("api/documents", "create", "DocumentsController");
Routing::post("api/documents/update", "update", "DocumentsController");
Routing::post("api/documents/delete", "delete", "DocumentsController");

// DocumentspositionsController
Routing::post("api/documentspositions", "create", "DocumentspositionsController");
Routing::post("api/documentspositions/delete", "remove", "DocumentspositionsController");

//ExchangesController
Routing::get("api/exchanges", "all", "ExchangesController");
Routing::post("api/exchanges/import", "fetchExchangesAndSave", "ExchangesController");

// WarehousesController
Routing::get("api/warehouses", "all", "WarehousesController");

// ContractorsController
Routing::get("api/contractors", "all", "ContractorsController");
Routing::post("api/contractors", "create", "ContractorsController");
Routing::post("api/contractors/delete", "remove", "ContractorsController");
Routing::post("api/contractors/update", "update", "ContractorsController");

// CurrenciesController
Routing::get("api/currencies", "all", "CurrenciesController");

// CommoditiesController
Routing::get("api/commodities", "all", "CommoditiesController");
Routing::post("api/commodities", "create", "CommoditiesController");
Routing::post("api/commodities/delete", "remove", "CommoditiesController");
Routing::post("api/commodities/update", "update", "CommoditiesController");

// UnitsController
Routing::get("api/units", "all", "UnitsController");

// VatratesController
Routing::get("api/vatrates", "all", "VatratesController");

// UsersController
Routing::get("api/users", "all", "UsersController");
Routing::get("api/users/one", "one", "UsersController");
Routing::post("api/users", "create", "UsersController");
Routing::post("api/users/delete", "remove", "UsersController");
Routing::post("api/users/update", "update", "UsersController");

// RolesController
Routing::get("api/roles", "all", "RolesController");

Routing::run($path);
