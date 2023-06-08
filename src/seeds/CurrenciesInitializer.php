<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Currency.php";

// Services
require_once __DIR__."/../services/ExchangesService.php";
require_once __DIR__."/../services/CurrenciesService.php";

class CurrenciesInitializer implements IInitializer
{
    private $exchangesService;
    private $currenciesService;

    public function __construct()
    {
        $this->exchangesService = new ExchangesService();
        $this->currenciesService = new CurrenciesService();
    }

    public function initialize(): void
    {
        $currencyPLN = new Currency(
            0,
          "PLN",
          "złoty"
        );
        $this->currenciesService->createCurrencyIfNotExists($currencyPLN);

        $days = 7;
        $exchanges = $this->exchangesService->fetchExchangesData($days);
        foreach ($exchanges[0]->rates as $rate)
        {
            $currency = new Currency(
                0,
                $rate->code,
                $rate->currency
            );

            $this->currenciesService->createCurrencyIfNotExists($currency);
        }

        // Exchanges
        $this->exchangesService->fetchExchangesAndSave($days);
    }
}