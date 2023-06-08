<?php

require_once "AppController.php";

class DefaultController extends AppController
{
    public function index() {
        $this->render("index");
    }

    public function home() {
        $this->render("home");
    }

    // Documents
    public function documents() {
        $this->render("documents");
    }

    public function documentsAll() {
        $this->render("documentsAll");
    }

    public function documentsOrders() {
        $this->render("documentsOrders");
    }

    public function documentsInvoices() {
        $this->render("documentsInvoices");
    }

    public function documentsOffers() {
        $this->render("documentsOffers");
    }

    // Contractors
    public function contractors() {
        $this->render("contractors");
    }

    // Commodities
    public function commodities() {
        $this->render("commodities");
    }

    // Exchanges
    public function exchanges() {
        $this->render("exchanges");
    }

    // Settings
    public function settings() {
        $this->render("settings");
    }

    public function settingsMain() {
        $this->render("settingsMain");
    }

    public function settingsDocumentsdefinitions() {
        $this->render("settingsDocumentsdefinitions");
    }

    public function settingsAccount() {
        $this->render("settingsAccount");
    }

    public function settingsUsers() {
        $this->render("settingsUsers");
    }
}