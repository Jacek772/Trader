<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }

    $_SESSION["location"] = "/settings/account";

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
    <link rel="stylesheet" href="/public/css/modal.css">
    <link rel="stylesheet" href="/public/css/pageform.css">
    <link rel="stylesheet" href="/public/css/settingsAccount.css">

    <!-- JS -->
    <script>
        let iduser = <?= $_SESSION["user"]->getIdUser() ?>;
    </script>

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>
    <script src="/public/js/components/modal/modal.js"></script>
    <script src="/public/js/components/pageform/pageform.js"></script>
    <script src="/public/js/components/pageform/pageformField.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>
    <script src="/public/js/api/ApiUsers.js"></script>

    <script src="/public/js/settingsAccount.js"></script>
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
                <h1 class="user-section-title">Settings account</h1>
            </div>

            <div id="pageformContainerSettingsAccount">

            </div>
        </section>
</div>

</body>
</html>