<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Currency.php";

class CurrenciesRepository extends Repository
{
    public function getCurrency(string $symbol): ?Currency
    {
        $query = "SELECT * FROM trader.currencies WHERE symbol = :symbol";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->execute();

        $currency = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$currency)
        {
            return null;
        }

        return new Currency(
            $currency["idcurrency"],
            $currency["symbol"],
            $currency["name"]
        );
    }

    public function createCurrency(Currency $currency): void
    {
        $query = "INSERT INTO trader.currencies (idcurrency, symbol, name) VALUES (DEFAULT, :symbol, :name)";

        $symbol = $currency->getSymbol();
        $name = $currency->getName();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $symbol, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
    }
}