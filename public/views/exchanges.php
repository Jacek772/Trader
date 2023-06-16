<?php
session_start();
if(!$_SESSION["logged"])
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
    <link rel="stylesheet" href="/public/css/documents.css">
    <link rel="stylesheet" href="/public/css/editform.css">

    <!-- JS -->
    <script src="/public/js/numberTools.js"></script>

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/dataGrid/rows.js"></script>
    <script src="/public/js/components/dataGrid/dataGrid.js"></script>
    <script src="/public/js/components/filtersPanel.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiExchanges.js"></script>

    <script src="/public/js/index.js"></script>
    <script src="/public/js/exchanges.js"></script>
    <title>Trader - Documents invoices</title>
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
                <h1 class="user-section-title">Exchanges</h1>
                <div>
                    <input type="text" placeholder="Search" class="input-text input-border" id="inputSearch">
                </div>
            </div>

            <!-- filters panel -->
            <div id="filtersPanelContainer">

            </div>

            <!-- action buttons -->
            <div class="action-buttons-container">
                <div class="action-buttons-item">
                    <button id="btnImportExchanges" class="button button-secondary">Import exchanges</button>
                </div>
            </div>

            <!-- table -->
            <div id="dataGridContainer" class="data-grid-container">

            </div>
        </section>
    </main>
</div>

</body>
</html>