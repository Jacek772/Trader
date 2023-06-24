<?php

// Repositories
require_once __DIR__."/../repository/ContractorsRepository.php";

// Models
require_once __DIR__."/../models/Contractor.php";

class ContractorsService
{
    private $contractorsRepository;

    public function __construct()
    {
        $this->contractorsRepository = new ContractorsRepository();
    }

    public function createContractorIfNotExists(Contractor $contractor):void
    {
        if(!$this->existsContractor($contractor->getCompanyname()))
        {
            $this->createContractor($contractor);
        }
    }

    public function createContractor(Contractor $contractor): void
    {
        $this->contractorsRepository->createContractor($contractor);
    }

    public function updateContractor(int $idcontractor,  array $contractorData): void
    {
        $this->contractorsRepository->updateContractor($idcontractor, $contractorData);
    }

    public function existsContractor(?string $companyname): bool
    {
        if(!$companyname)
        {
            return false;
        }

        $contractor = $this->getContractor($companyname);
        return $contractor != null;
    }

    public function getAllContractors(): array
    {
        return $this->contractorsRepository->getAllContractors();
    }

    public function getContractor(?string $companyname): ?Contractor
    {
        if(!$companyname)
        {
            return null;
        }
        return $this->contractorsRepository->getContractor($companyname);
    }

    public function deleteContractors(array $ids): void
    {
        $this->contractorsRepository->deleteContractors($ids);
    }
}