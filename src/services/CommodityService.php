<?php

// Repositories
require_once __DIR__."/../repository/CommodityRepository.php";

// Models
require_once __DIR__."/../models/Commodity.php";

class CommodityService
{
    private $commodityRepository;

    public function __construct()
    {
        $this->commodityRepository = new CommodityRepository();
    }

    public function createCommodityIfNotExists(Commodity $commodity): void
    {
        if(!$this->existsCommodity($commodity->getSymbol()))
        {
            $this->createCommodity($commodity);
        }
    }

    public function getAllCommodities(): array
    {
        return $this->commodityRepository->getAllCommodities();
    }

    public function getCommodity(string $symbol): ?Commodity
    {
        return $this->commodityRepository->getCommodity($symbol);
    }

    public function createCommodity(Commodity $commodity): void
    {
        $this->commodityRepository->createCommodity($commodity);
    }

    public function deleteCommodities($ids): void
    {
        $this->commodityRepository->deleteCommodities($ids);
    }

    public function updateCommodity(int $idcommodity, array $commodityData): void
    {
        $this->commodityRepository->updateCommodity($idcommodity, $commodityData);
    }

    public function existsCommodity(string $symbol): bool
    {
        if(!$symbol)
        {
            return false;
        }

        $commodity = $this->getCommodity($symbol);
        return $commodity != null;
    }
}