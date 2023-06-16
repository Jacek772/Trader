<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Exchange.php";


class ExchangesRepository extends Repository
{
    public function getAllExchanges(): array
    {
        $query = "SELECT e.idexchange e_idexchange, e.dateofpublication e_dateofpublication, e.announcementdate e_announcementdate,
                   e.tablenumber e_tablenumber, e.factor e_factor, e.rate e_rate,
                   c.idcurrency c_idcurrency, c.symbol c_symbol, c.name c_name
                    FROM trader.exchanges e
                    INNER JOIN trader.currencies c ON c.idcurrency = e.idcurrency
                    ORDER BY e.dateofpublication DESC";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();
        $exchangesData = $stmt->fetchAll();

        if(!$exchangesData)
        {
            return [];
        }

        $exchanges = [];
        foreach ($exchangesData as $exchangeData)
        {
            $exchange = new Exchange(
                $exchangeData["e_idexchange"],
                $exchangeData["e_dateofpublication"],
                $exchangeData["e_announcementdate"],
                $exchangeData["e_tablenumber"],
                $exchangeData["e_factor"],
                $exchangeData["e_rate"],
                $exchangeData["c_idcurrency"]
            );

            $currency = new Currency(
                $exchangeData["c_idcurrency"],
                $exchangeData["c_symbol"],
                $exchangeData["c_name"]
            );

            $exchange->setCurrency($currency);

            array_push($exchanges, $exchange);
        }
        return $exchanges;
    }

    public function getLastExchangeByCurrencySymbol(string $date, string $currencySymbol): ?Exchange
    {
        $query = "SELECT e.* FROM trader.exchanges e
                    INNER JOIN trader.currencies c ON c.idcurrency = e.idcurrency
                    WHERE c.symbol = :symbol AND e.dateofpublication <= :date
                    ORDER BY e.dateofpublication DESC LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $currencySymbol, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->execute();

        $exchange = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$exchange)
        {
            return null;
        }

        return new Exchange(
            $exchange["idexchange"],
            $exchange["dateofpublication"],
            $exchange["announcementdate"],
            $exchange["tablenumber"],
            $exchange["factor"],
            $exchange["rate"],
            $exchange["idcurrency"]
        );
    }

    public function getExchangeByCurrencySymbol(string $date, string $currencySymbol): ?Exchange
    {
        $query = "SELECT e.* FROM trader.exchanges e
                    INNER JOIN trader.currencies c ON c.idcurrency = e.idcurrency
                    WHERE c.symbol = :symbol AND e.dateofpublication = :date
                    ORDER BY e.dateofpublication DESC LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":symbol", $currencySymbol, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->execute();

        $exchange = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$exchange)
        {
            return null;
        }

        return new Exchange(
            $exchange["idexchange"],
            $exchange["dateofpublication"],
            $exchange["announcementdate"],
            $exchange["tablenumber"],
            $exchange["factor"],
            $exchange["rate"],
            $exchange["idcurrency"]
        );
    }

    public function getExchange(string $date, int $idcurrency): ?Exchange
    {
        $query = "SELECT * FROM trader.exchanges WHERE dateofpublication = :date AND idcurrency = :idcurrency LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":idcurrency", $idcurrency, PDO::PARAM_INT);
        $stmt->execute();

        $exchange = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$exchange)
        {
            return null;
        }

        return new Exchange(
            $exchange["idexchange"],
            $exchange["dateofpublication"],
            $exchange["announcementdate"],
            $exchange["tablenumber"],
            $exchange["factor"],
            $exchange["rate"],
            $exchange["idcurrency"]
        );
    }

    public function createExchange(Exchange $exchange): void
    {
        $query = "INSERT INTO trader.exchanges (idexchange, dateofpublication, announcementdate, tablenumber, factor, rate, idcurrency)
                    VALUES (DEFAULT, :dateofpublication, :announcementdate, :tablenumber, :factor, :rate, :idcurrency)";

        $stmt = $this->databse->connect()->prepare($query);
        $params = array(
            ":dateofpublication" => $exchange->getDateofpublication(),
            ":announcementdate" => $exchange->getAnnouncementdate(),
            ":tablenumber" => $exchange->getTablenumber(),
            ":factor" => $exchange->getFactor(),
            ":rate" => $exchange->getRate(),
            ":idcurrency" => $exchange->getIdcurrency()
        );
        $stmt->execute($params);
    }
}