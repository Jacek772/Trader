<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Contractor.php";

class ContractorsRepository extends Repository
{
    public function getAllContractors(): array
    {
        $query = "SELECT * FROM trader.contractors";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $contractorsData = $stmt->fetchAll();
        if(!$contractorsData)
        {
            return [];
        }

        $contractors = [];
        foreach ($contractorsData as $contractorData)
        {
            $contractor = new Contractor(
                $contractorData["idcontractor"],
                $contractorData["companyname"],
                $contractorData["nip"],
                $contractorData["pesel"],
                $contractorData["idaddress"],
                $contractorData["iduser"]
            );

            array_push($contractors, $contractor);
        }
        return $contractors;
    }

    public function getContractor(string $companyname): ?Contractor
    {
        $query = "SELECT * FROM trader.contractors WHERE companyname = :companyname";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":companyname", $companyname, PDO::PARAM_STR);
        $stmt->execute();

        $contractor = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$contractor)
        {
            return null;
        }

        return new Contractor(
            $contractor["idcontractor"],
            $contractor["companyname"],
            $contractor["nip"],
            $contractor["pesel"],
            $contractor["idaddress"],
            $contractor["iduser"]
        );
    }

    public function createContractor(Contractor $contractor): void
    {
        $query = "INSERT INTO trader.contractors (idcontractor, companyname, nip, pesel, idaddress, iduser) VALUES (DEFAULT, :companyname, :nip, :pesel, :idaddress, :iduser)";

        $companyname = $contractor->getCompanyname();
        $nip = $contractor->getNip();
        $pesel = $contractor->getPesel();
        $idaddress = $contractor->getIdaddress();
        $iduser = $contractor->getIduser();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":companyname", $companyname, PDO::PARAM_STR);
        $stmt->bindParam(":nip", $nip, PDO::PARAM_STR);
        $stmt->bindParam(":pesel", $pesel, PDO::PARAM_STR);
        $stmt->bindParam(":idaddress", $idaddress, PDO::PARAM_INT);
        $stmt->bindParam(":iduser", $iduser, PDO::PARAM_INT);
        $stmt->execute();
    }

}