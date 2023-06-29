<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }
    $_SESSION["location"] = "/settings/main";

    $roleName = $_SESSION["user"]->getRole()->getName();
    if($roleName != "Administrator")
    {
        header('Location: /');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/public/css/zero.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/pageform.css">
    <link rel="stylesheet" href="/public/css/settingsMain.css">

    <!-- JS -->
    <script src="/public/js/numberTools.js"></script>

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/pageform/pageformField.js"></script>
    <script src="/public/js/components/pageform/pageform.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiCurrencies.js"></script>

    <script src="/public/js/settingsMain.js"></script>
    <title>Trader - settings main</title>
</head>
<body>
<div class="container">
    <!-- header -->
    <?php
        require_once(__DIR__."/../components/header.php")
    ?>

    <main class="user-main">
        <!-- nav -->
        <?php
            require_once(__DIR__."/../components/navigation.php")
        ?>

        <section class="user-section">
            <div class="user-section-title-container color-darkgray">
                <h1 class="user-section-title">Settings - Main</h1>
                <div>
                    <input type="text" placeholder="Search" class="input-text input-border" id="inputSearch">
                </div>
            </div>

            <div id="pageformContainer">

            </div>
        </section>
</div>

</body>
</html>