<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }

    $_SESSION["location"] = "/commodities";

    $roleName = $_SESSION["user"]->getRole()->getName();
    if($roleName != "Administrator" && $roleName != "Trader")
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

    <!-- JS -->
    <script src="/public/js/numberTools.js"></script>

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/dataGrid/rows.js"></script>
    <script src="/public/js/components/dataGrid/dataGrid.js"></script>
    <script src="/public/js/components/filtersPanel.js"></script>
    <script src="/public/js/components/dataForm/dataFormField.js"></script>
    <script src="/public/js/components/dataForm/dataForm.js"></script>
    <script src="/public/js/components/modal/modal.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiCommodities.js"></script>
    <script src="/public/js/api/ApiVatrates.js"></script>
    <script src="/public/js/api/ApiUnits.js"></script>

    <script src="/public/js/commodities.js"></script>
    <title>Trader - Commodities</title>
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
                <h1 class="user-section-title">Commodities</h1>
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
                    <button id="btnNew" class="button button-primary">New</button>
                </div>
                <div class="action-buttons-item">
                    <button id="btnDelete" class="button button-danger">Delete</button>
                </div>
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

<div class="overlay" style="display: none;">
    <!--    <div class="overlay">-->
    <div class="editform-container">
        <div class="editform-head">
            <input type="text" id="inputText" />
            <script>
                const inputText = document.getElementById("inputText")
                inputText.addEventListener("input", (e) => {
                    console.log("input")
                })

                inputText.addEventListener("keydown", (e) => {
                    console.log(e.key)
                    if(e.key == "Enter")
                    {
                        // Zapis zmian
                        e.target.blur()
                    }

                    if(e.key == "Escape")
                    {
                        // Cofnięcie zmian
                        e.target.blur()
                    }
                })


                inputText.addEventListener("blur", (e) => {
                    console.log("BLUR")
                })
            </script>

            <img src="public/img/svg/close.svg" id="iconEditformClose" class="icon icon-clicable" alt="iconClose" />
            <button class="button button-secondary">Save</button>
            <h2 class="editform-head-title">FS/000001/05/2023</h2>
        </div>
        <div class="editform-body">
            <div class="editform-body-fields-container">
                <div class="editform-body-fields-row">
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">State</label>
                        <select class="input-text input-border">
                            <option>test</option>
                        </select>
                    </div>
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">Date</label>
                        <input type="date" class="input-text input-border" />
                    </div>
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">Warehouse</label>
                        <select class="input-text input-border">
                            <option>test</option>
                        </select>
                    </div>
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">Currency</label>
                        <select class="input-text input-border">
                            <option>EUR - Euro</option>
                        </select>
                    </div>
                </div>
                <div class="editform-body-fields-row">
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">Contractor</label>
                        <select class="input-text input-border">
                            <option>Januszex Company Sp. z.o.o.</option>
                            <option>test</option>
                        </select>
                    </div>
                </div>
                <div class="editform-body-fields-row">
                    <div class="editform-body-fields-item">
                        <label class="input-text-label">Description</label>
                        <textarea class="input-text input-border"></textarea>
                    </div>
                </div>
            </div>
            <div class="action-buttons-container">
                <div class="action-buttons-item">
                    <button class="button button-primary">New</button>
                </div>
                <div class="action-buttons-item">
                    <button class="button button-danger">Delete</button>
                </div>
            </div>
            <div id="dataGridTest" class="data-grid-container">

            </div>
        </div>
        <div class="editform-footer">
            <div class="editform-footer-row">
                <div class="editform-footer-table-sum-continer">
                    <table class="editform-footer-table-sum">
                        <tr>
                            <td>
                                <p class="editform-footer-table-sum-label">Value net:</p>
                            </td>
                            <td>
                                <input type="number" class="input-text input-border" />
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid";>
                            <td>
                                <p class="editform-footer-table-sum-label">Value VAT:</p>
                            </td>
                            <td>
                                <input type="number" class="input-text input-border" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="editform-footer-table-sum-label">Value gross:</p>
                            </td>
                            <td>
                                <input type="number" class="input-text input-border" />
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>