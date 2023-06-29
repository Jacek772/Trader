<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }

    $_SESSION["location"] = "/documents/orders";
    $roleName = $_SESSION["user"]->getRole()->getName();
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
    <link rel="stylesheet" href="/public/css/modal.css">

    <!-- JS -->
    <script src="/public/js/numberTools.js"></script>
    <script>
        let roleName = "<?= $roleName ?>";
    </script>

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/dataGrid/rows.js"></script>
    <script src="/public/js/components/dataGrid/dataGrid.js"></script>
    <script src="/public/js/components/filtersPanel.js"></script>
    <script src="/public/js/components/modal/modal.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiDocuments.js"></script>
    <script src="/public/js/api/ApiContractors.js"></script>
    <script src="/public/js/api/ApiWarehouses.js"></script>

    <script src="/public/js/documentsOrders.js"></script>
    <title>Trader - Documents orders</title>
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
                <h1 class="user-section-title">Documents orders</h1>
                <div>
                    <input type="text" placeholder="Search" class="input-text input-border" id="inputSearch">
                </div>
            </div>

            <!-- filters panel -->
            <div id="filtersPanelContainer">

            </div>

            <!-- action buttons -->
            <div class="action-buttons-container">
                <?php if($roleName == "Administrator" || $roleName == "Trader"): ?>
                    <div class="action-buttons-item">
                        <button id="btnNew" class="button button-primary">New</button>
                    </div>
                    <div class="action-buttons-item">
                        <button id="btnDelete" class="button button-danger">Delete</button>
                    </div>
                <?php endif; ?>
                <div class="action-buttons-item">
                    <button id="btnOpenForm" class="button button-dark">Open</button>
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