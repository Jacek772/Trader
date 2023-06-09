<?php

require_once "Repository.php";

// Models
require_once __DIR__."/../models/Vatrate.php";

class VatratesRepository extends Repository
{
    public function getAllVatrates(): array
    {
        $query = "SELECT * FROM trader.vatrates";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $vatratesData = $stmt->fetchAll();
        if(!$vatratesData)
        {
            return [];
        }

        $vatrates = [];
        foreach ($vatratesData as $vatrateData)
        {
            $vatrate = new Vatrate(
                $vatrateData["idvatrate"],
                $vatrateData["percent"]
            );

            array_push($vatrates, $vatrate);
        }

        return $vatrates;
    }

    public function getVatrate(float $percent): ?Vatrate
    {
        $query = "SELECT * FROM trader.vatrates WHERE percent = :percent LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":percent", $percent, PDO::PARAM_STR);
        $stmt->execute();

        $vatrate = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$vatrate)
        {
            return null;
        }
        return new Vatrate(
            $vatrate["idvatrate"],
            $vatrate["percent"]
        );
    }

    public function createVatrate(Vatrate $vatrate): void
    {
        $query = "INSERT INTO trader.vatrates VALUES (DEFAULT, :percent)";

        $percent = $vatrate->getPercent();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":percent", $percent, PDO::PARAM_STR);
        $stmt->execute();
    }

}