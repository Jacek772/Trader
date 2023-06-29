<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }
    $_SESSION["location"] = "/settings/documentsdefinitions";

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
    <link rel="stylesheet" href="/public/css/editform.css">
    <link rel="stylesheet" href="/public/css/modal.css">

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/modal/modal.js"></script>
    <script src="/public/js/components/dataGrid/dataGrid.js"></script>
    <script src="/public/js/components/dataGrid/rows.js"></script>
    <script src="/public/js/components/dataForm/dataFormField.js"></script>
    <script src="/public/js/components/dataForm/dataForm.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiDocumentsdefinitions.js"></script>

    <script src="/public/js/settingsDocumentsdefinitions.js"></script>
    <title>Trader - settings account</title>
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
                <h1 class="user-section-title">Settings - Documents definitions</h1>
                <div>
                    <input type="text" placeholder="Search" class="input-text input-border" id="inputSearch">
                </div>
            </div>

            <!-- action buttons -->
            <div class="action-buttons-container">
                <div class="action-buttons-item">
                    <button id="btnNew" class="button button-primary">New</button>
                </div>
                <div class="action-buttons-item">
                    <button id="btnDelete" class="button button-danger">Delete</button>
                </div>
                <div class="action-buttons-item">
                    <button id="btnOpenForm" class="button button-dark">Open</button>
                </div>
            </div>

            <!-- data grid -->
            <div id="dataGridContainer" class="data-grid-container">

            </div>
        </section>
</div>

</body>
</html>