<?php
    $roleName = $_SESSION["user"]->getRole()->getName();
?>

<script src="/public/js/navigation.js"></script>

<nav class="nav">
  <ul>
    <li class="nav-item">
      <a href="/home" class="nav-link <?= $_SESSION["location"] == "/home" ? "nav-link-active" : "" ?>">Home</a>
    </li>
    <?php if($roleName == "Administrator" || $roleName == "Trader"): ?>
        <li class="nav-item">
          <div class="nav-item-main">
            <a href="/documents" class="nav-link <?= substr($_SESSION["location"], 0, 10) == "/documents" ? "nav-link-active" : "" ?>">Documents</a>
            <img src="/public/img/svg/arrow-down.svg" id="iconDocumentsSubnav" class="icon-small icon-clicable" alt="iconDocumentsArrow" />
          </div>
          <ul id="ulDocumentsSubnav">
            <li class="nav-item">
              <a href="/documents" class="nav-link <?= $_SESSION["location"] == "/documents" ? "nav-link-active" : "" ?>">Documents</a>
            </li>
            <li class="nav-item">
              <a href="/documents/all" class="nav-link <?= $_SESSION["location"] == "/documents/all" ? "nav-link-active" : "" ?>">All</a>
            </li>
            <li class="nav-item">
              <a href="/documents/offers" class="nav-link <?= $_SESSION["location"] == "/documents/offers" ? "nav-link-active" : "" ?>">Offers</a>
            </li>
            <li class="nav-item">
              <a href="/documents/orders" class="nav-link <?= $_SESSION["location"] == "/documents/orders" ? "nav-link-active" : "" ?>">Orders</a>
            </li>
            <li class="nav-item">
              <a href="/documents/sale" class="nav-link <?= $_SESSION["location"] == "/documents/sale" ? "nav-link-active" : "" ?>">Sale</a>
            </li>
          </ul>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <div class="nav-item-main">
                <a href="/documents/offers" class="nav-link <?= substr($_SESSION["location"], 0, 10) == "/documents" ? "nav-link-active" : "" ?>">Documents</a>
                <img src="/public/img/svg/arrow-down.svg" id="iconDocumentsSubnav" class="icon-small icon-clicable" alt="iconDocumentsArrow" />
            </div>
            <ul id="ulDocumentsSubnav">
                <li class="nav-item">
                    <a href="/documents/offers" class="nav-link <?= $_SESSION["location"] == "/documents/offers" ? "nav-link-active" : "" ?>">Offers</a>
                </li>
                <li class="nav-item">
                    <a href="/documents/orders" class="nav-link <?= $_SESSION["location"] == "/documents/orders" ? "nav-link-active" : "" ?>">Orders</a>
                </li>
                <li class="nav-item">
                    <a href="/documents/sale" class="nav-link <?= $_SESSION["location"] == "/documents/sale" ? "nav-link-active" : "" ?>">Sale</a>
                </li>
            </ul>
        </li>
    <?php endif; ?>
    <?php if($roleName == "Administrator" || $roleName == "Trader"): ?>
        <li class="nav-item">
          <a href="/contractors" class="nav-link <?= $_SESSION["location"] == "/contractors" ? "nav-link-active" : "" ?>">Contractors</a>
        </li>
        <li class="nav-item">
          <a href="/commodities" class="nav-link <?= $_SESSION["location"] == "/commodities" ? "nav-link-active" : "" ?>">Commodities</a>
        </li>
        <li class="nav-item">
          <a href="/exchanges" class="nav-link <?= $_SESSION["location"] == "/exchanges" ? "nav-link-active" : "" ?>">Exchanges</a>
        </li>
    <?php endif; ?>
    <?php if($roleName == "Administrator"): ?>
        <li class="nav-item">
          <div class="nav-item-main">
            <a href="/settings/main" class="nav-link <?= substr($_SESSION["location"], 0, 9) == "/settings" ? "nav-link-active" : "" ?>">Settings</a>
            <img src="/public/img/svg/arrow-down.svg" id="iconSettingsSubnav" class="icon-small icon-clicable" alt="iconSettingsArrow" />
          </div>
            <ul id="ulSettingsSubnav">
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
    <?php endif; ?>
  </ul>
</nav>
