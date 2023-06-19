<?php

?>

<nav class="nav">
  <ul>
    <li class="nav-item">
      <a href="/home" class="nav-link <?= $_SESSION["location"] == "/home" ? "nav-link-active" : "" ?>">Home</a>
    </li>
    <li class="nav-item">
      <div class="nav-item-main">
        <a href="/documents" class="nav-link <?= $_SESSION["location"] == "/documents" ? "nav-link-active" : "" ?>">Documents</a>
        <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable rotate-180" style="display: none;" alt="iconDocumentsArrowUp" />
        <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable" alt="iconDocumentsArrowDown" />
      </div>
      <ul>
        <li class="nav-item">
          <a href="/documents/all" class="nav-link <?= $_SESSION["location"] == "/documents/all" ? "nav-link-active" : "" ?>">All</a>
        </li>
        <li class="nav-item">
          <a href="/documents/orders" class="nav-link <?= $_SESSION["location"] == "/documents/orders" ? "nav-link-active" : "" ?>">Orders</a>
        </li>
        <li class="nav-item">
          <a href="/documents/invoices" class="nav-link <?= $_SESSION["location"] == "/documents/invoices" ? "nav-link-active" : "" ?>">Invoices</a>
        </li>
        <li class="nav-item">
          <a href="/documents/offers" class="nav-link <?= $_SESSION["location"] == "/documents/offers" ? "nav-link-active" : "" ?>">Offers</a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="/contractors" class="nav-link <?= $_SESSION["location"] == "/contractors" ? "nav-link-active" : "" ?>">Contractors</a>
    </li>
    <li class="nav-item">
      <a href="/commodities" class="nav-link <?= $_SESSION["location"] == "/commodities" ? "nav-link-active" : "" ?>">Commodities</a>
    </li>
    <li class="nav-item">
      <a href="/exchanges" class="nav-link <?= $_SESSION["location"] == "/exchanges" ? "nav-link-active" : "" ?>">Exchanges</a>
    </li>
    <li class="nav-item">
      <div class="nav-item-main">
        <a href="/settings" class="nav-link <?= $_SESSION["location"] == "/settings" ? "nav-link-active" : "" ?>">Settings</a>
        <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable rotate-180" style="display: none;" alt="iconSettingsArrowUp" />
        <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable" alt="iconSettingsArrowDown" />
      </div>
      <ul>
        <li class="nav-item">
          <a href="/settings/main" class="nav-link <?= $_SESSION["location"] == "/settings/main" ? "nav-link-active" : "" ?>">Main</a>
        </li>
        <li class="nav-item">
          <a href="/settings/documentsdefinitions" class="nav-link <?= $_SESSION["location"] == "/settings/documentsdefinitions" ? "nav-link-active" : "" ?>">Documents definitions</a>
        </li>
        <li class="nav-item">
          <a href="/settings/account" class="nav-link <?= $_SESSION["location"] == "/settings/account" ? "nav-link-active" : "" ?>">Account</a>
        </li>
        <li class="nav-item">
          <a href="/settings/users" class="nav-link <?= $_SESSION["location"] == "/settings/users" ? "nav-link-active" : "" ?>">Users</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
