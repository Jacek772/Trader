<?php

// Models
require_once __DIR__."/../models/Exchange.php";

// Repositories
require_once __DIR__."/../repository/ExchangesRepository.php";
require_once __DIR__."/../repository/CurrenciesRepository.php";

class ExchangesService
{
    private $exchangesRepository;
    private $currenciesRepository;

    public function __construct()
    {
        $this->exchangesRepository = new ExchangesRepository();
        $this->currenciesRepository = new CurrenciesRepository();
    }

    public function fetchExchangesAndSave(int $days): void
    {
        $exchangesData = $this->fetchExchangesData($days);
        foreach ($exchangesData as $exchangeData)
        {
            foreach ($exchangeData->rates as $rate)
            {
                $currency = $this->currenciesRepository->getCurrency($rate->code);
                if(!$currency)
                {
                    continue;
                }

                $exchange = new Exchange(
                    0,
                    $exchangeData->effectiveDate,
                    $exchangeData->effectiveDate,
                    $exchangeData->no,
                    1,
                    $rate->mid,
                    $currency->getIdcurrency()
                );

                $this->createExchangeIfNotExists($exchange);
            }
        }
    }

    public function fetchExchangesData(int $days): array
    {
        if($days > 67)
        {
            throw new Exception("days value cannot by greater than 67.");
        }
        $xml = file_get_contents("http://api.nbp.pl/api/exchangerates/tables/A/last/$days");
        $tables = json_decode($xml);
        return $tables;
    }

    public function createExchangeIfNotExists(Exchange $exchange): void
    {
        if(!$this->existsExchange($exchange->getDateofpublication(), $exchange->getIdcurrency()))
        {
            $this->createExchange($exchange);
        }
    }

    public function createExchange(Exchange $exchange): void
    {
        $this->exchangesRepository->createExchange($exchange);
    }

    public function existsExchange(string $date, int $idcurrency): bool
    {
        $exchange = $this->getExchange($date, $idcurrency);
        return $exchange != null;
    }

    public function getLastExchangeByCurrencySymbol(string $date, string $currencySymbol): ?Exchange
    {
        return $this->exchangesRepository->getLastExchangeByCurrencySymbol($date, $currencySymbol);
    }

    public function getExchangeByCurrencySymbol(string $date, string $currencySymbol): ?Exchange
    {
        return $this->exchangesRepository->getExchangeByCurrencySymbol($date, $currencySymbol);
    }

    public function getExchange(string $date, int $idcurrency): ?Exchange
    {
        return $this->exchangesRepository->getExchange($date, $idcurrency);
    }

}