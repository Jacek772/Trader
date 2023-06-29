<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }

    $_SESSION["location"] = "/home";
    $roleName = $_SESSION["user"]->getRole()->getName();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/zero.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/home.css">
  <title>Trader - Home</title>
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
        <h1 class="user-section-title">Hello user <?= $_SESSION["user"]->getName() ?>!</h1>
        <div>
          <input type="text" placeholder="Search" class="input-text input-border">
        </div>
      </div>
      <div class="navcard color-white">
        <?php if($roleName == "Administrator" || $roleName == "Trader"): ?>
            <a class="navcard-a" href="/documents">
        <?php else: ?>
            <a class="navcard-a" href="/documents/offers">
        <?php endif; ?>
          <div class="navcard-title-container">
            <img src="/public/img/svg/document.svg" alt="document" class="icon">
            <h2 class="navcard-title">Documents</h2>
          </div>
          <p class="navcard-text">All documents - orders, invoices etc.</p>
        </a>
      </div>
    <?php if($roleName == "Administrator" || $roleName == "Trader"): ?>
      <div class="navcard color-white">
        <a class="navcard-a" href="/contractors">
          <div class="navcard-title-container">
            <img src="/public/img/svg/person.svg" alt="document" class="icon">
            <h2 class="navcard-title">Contractors</h2>
          </div>
          <p class="navcard-text">All contractors</p>
        </a>
      </div>
      <div class="navcard color-white">
        <a class="navcard-a" href="/commodities">
          <div class="navcard-title-container">
            <img src="/public/img/svg/product.svg" alt="document" class="icon">
            <h2 class="navcard-title">Commodities</h2>
          </div>
          <p class="navcard-text">All commodities</p>
        </a>
      </div>
      <div class="navcard color-white">
        <a class="navcard-a" href="/exchanges">
          <div class="navcard-title-container">
            <img src="/public/img/svg/currency.svg" alt="document" class="icon">
            <h2 class="navcard-title">Exchanges</h2>
          </div>
          <p class="navcard-text">All currencies</p>
        </a>
      </div>
    <?php endif; ?>
    <?php if($roleName == "Administrator"): ?>
      <div class="navcard color-white">
        <a class="navcard-a" href="/settings/main">
          <div class="navcard-title-container">
            <img src="/public/img/svg/settings.svg" alt="document" class="icon">
            <h2 class="navcard-title">Settings</h2>
          </div>
          <p class="navcard-text">Application settings</p>
        </a>
      </div>
    <?php endif; ?>
    </section>
  </main>
</div>
</body>
</html>