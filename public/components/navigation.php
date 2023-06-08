<?php
echo '
 <nav class="nav">
      <ul>
        <li class="nav-item">
          <a href="/home" class="nav-link nav-link-active">Home</a>
        </li>
        <li class="nav-item">
          <div class="nav-item-main">
            <a href="/documents" class="nav-link">Documents</a>
            <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable rotate-180" style="display: none;" alt="iconDocumentsArrowUp" />
            <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable" alt="iconDocumentsArrowDown" />
          </div>
          <ul>
            <li class="nav-item">
              <a href="/documents/all" class="nav-link">All</a>
            </li>
            <li class="nav-item">
              <a href="/documents/orders" class="nav-link">Orders</a>
            </li>
            <li class="nav-item">
              <a href="/documents/invoices" class="nav-link">Invoices</a>
            </li>
            <li class="nav-item">
              <a href="/documents/offers" class="nav-link">Offers</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/contractors" class="nav-link">Contractors</a>
        </li>
        <li class="nav-item">
          <a href="/commodities" class="nav-link">Commodities</a>
        </li>
        <li class="nav-item">
          <a href="/exchanges" class="nav-link">Exchanges</a>
        </li>
        <li class="nav-item">
          <div class="nav-item-main">
            <a href="/settings" class="nav-link">Settings</a>
            <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable rotate-180" style="display: none;" alt="iconSettingsArrowUp" />
            <img src="/public/img/svg/arrow-down.svg" class="icon-small icon-clicable" alt="iconSettingsArrowDown" />
          </div>
          <ul>
            <li class="nav-item">
              <a href="/settings/main" class="nav-link">Main</a>
            </li>
            <li class="nav-item">
              <a href="/settings/documentsdefinitions" class="nav-link">Documents definitions</a>
            </li>
            <li class="nav-item">
              <a href="/settings/account" class="nav-link">Account</a>
            </li>
            <li class="nav-item">
              <a href="/settings/users" class="nav-link">Users</a>
            </li>
          </ul>    
        </li>
      </ul>
    </nav>
';