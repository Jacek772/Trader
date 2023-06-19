<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }
    $_SESSION["location"] = "/settings/main";
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

    <!-- Components -->
    <script src="/public/js/components/htmlComponent.js"></script>

    <!-- Api -->
    <script src="/public/js/api/Api.js"></script>

    <script src="/public/js/index.js"></script>
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
            <h1>Settings main</h1>
        </section>
</div>

</body>
</html>