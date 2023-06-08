<?php

// Repositories
require_once __DIR__."/../repository/UnitsRepository.php";

// Models
require_once __DIR__."/../models/Unit.php";

class UnitsService
{
    private $unitsRepository;

    public function __construct()
    {
        $this->unitsRepository = new UnitsRepository();
    }

    public function createUnitIfNotExists(Unit $unit): void
    {
        if(!$this->existsUnit($unit->getSymbol()))
        {
            $this->createUnit($unit);
        }
    }

    public function createUnit(Unit $unit): void
    {
        $this->unitsRepository->createUnit($unit);
    }

    public function existsUnit(string $symbol): bool
    {
        if(!$symbol)
        {
            return false;
        }

        $unit = $this->getUnit($symbol);
        return $unit != null;
    }

    public function getUnit(string $symbol): ?Unit
    {
        return $this->unitsRepository->getUnit($symbol);
    }
}