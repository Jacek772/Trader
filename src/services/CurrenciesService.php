<?php

// Repositories
require_once __DIR__."/../repository/CurrenciesRepository.php";

// Models
require_once __DIR__."/../models/Currency.php";


class CurrenciesService
{
    private $currenciesRepository;

    public function __construct()
    {
        $this->currenciesRepository = new CurrenciesRepository();
    }

    public function createCurrencyIfNotExists(Currency $currency): void
    {
        if(!$this->existsCurrency($currency->getSymbol()))
        {
            $this->createCurrency($currency);
        }
    }

    public function createCurrency(Currency $currency): void
    {
        $this->currenciesRepository->createCurrency($currency);
    }

    public function existsCurrency(?string $symbol): bool
    {
        if(!$symbol)
        {
            return false;
        }

        $currency = $this->getCurrency($symbol);
        return $currency != null;
    }

    public function getCurrency(?string $symbol): ?Currency
    {
        if(!$symbol)
        {
            return null;
        }
        return $this->currenciesRepository->getCurrency($symbol);
    }
}