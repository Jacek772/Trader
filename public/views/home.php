<?php
    session_start();
    if(!$_SESSION["logged"])
    {
        header('Location: /');
        die();
    }

    $_SESSION["location"] = "/home";
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
        <h1 class="user-section-title">Hello user Jacek!</h1>
        <div>
          <input type="text" placeholder="Search" class="input-text input-border">
        </div>
      </div>
      <div class="navcard color-white">
        <a class="navcard-a" href="/documents">
          <div class="navcard-title-container">
            <img src="/public/img/svg/document.svg" alt="document" class="icon">
            <h2 class="navcard-title">Documents</h2>
          </div>
          <p class="navcard-text">All documents - orders, invoices etc.</p>
        </a>

      </div>
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
      <div class="navcard color-white">
        <a class="navcard-a" href="/settings">
          <div class="navcard-title-container">
            <img src="/public/img/svg/settings.svg" alt="document" class="icon">
            <h2 class="navcard-title">Settings</h2>
          </div>
          <p class="navcard-text">Application settings</p>
        </a>
      </div>
    </section>
  </main>
</div>
</body>
</html>