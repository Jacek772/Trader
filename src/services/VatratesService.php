<?php

// Repositories
require_once __DIR__."/../repository/VatratesRepository.php";

// Models
require_once __DIR__."/../models/Vatrate.php";

class VatratesService
{
    private $vatratesRepository;

    public function __construct()
    {
        $this->vatratesRepository = new VatratesRepository();
    }

    public function createVatrateIfNotExists(Vatrate $vatrate): void
    {
        if(!$this->existsVatrate($vatrate->getPercent()))
        {
            $this->createVatrate($vatrate);
        }
    }

    public function createVatrate(Vatrate $vatrate): void
    {
        $this->vatratesRepository->createVatrate($vatrate);
    }

    public function existsVatrate(float $percent): bool
    {
        if($percent < 0)
        {
            return false;
        }

        $vatrate = $this->getVatrate($percent);
        return $vatrate != null;
    }

    public function getVatrate(float $percent): ?Vatrate
    {
        return $this->vatratesRepository->getVatrate($percent);
    }
}