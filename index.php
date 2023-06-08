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

// AuthController
Routing::post("api/auth/login", "login", "AuthController");
Routing::post("api/auth/logout", "logout", "AuthController");

//DocumentsController
Routing::get("api/documents", "all", "DocumentsController");

Routing::run($path);