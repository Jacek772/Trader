<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/Contractor.php";
require_once __DIR__."/../models/Address.php";

class ContractorsRepository extends Repository
{
    public function getAllContractors(): array
    {
        $query = "SELECT c.idcontractor idcontractor, c.companyname c_companyname, c.nip c_nip, c.pesel c_pesel,
                    a.idaddress, a.city a_city, a.street a_street, a.homenumber a_homenumber, a.localnumber a_localnumber, a.zipcode a_zipcode
                    FROM trader.contractors c
                    INNER JOIN trader.addresses a ON a.idaddress = c.idaddress";

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
                $contractorData["c_companyname"],
                $contractorData["c_nip"],
                $contractorData["c_pesel"],
                $contractorData["idaddress"],
                $contractorData["iduser"]
            );

            $address = new Address(
                $contractorData["idaddress"],
                $contractorData["a_city"],
                $contractorData["a_street"],
                $contractorData["a_homenumber"],
                $contractorData["a_localnumber"],
                $contractorData["a_zipcode"]
            );

            $contractor->setAddress($address);

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

    public function updateContractor(int $idcontractor,  array $contractorData): void
    {
        $columnNames = array();
        $params = array();
        $params[":idcontractor"] = $idcontractor;

        if(isset($contractorData["companyname"]))
        {
            $params[":companyname"] = $contractorData["companyname"];
            array_push($columnNames, "companyname = :companyname");
        }

        if(isset($contractorData["pesel"]))
        {
            $params[":pesel"] = $contractorData["pesel"];
            array_push($columnNames, "pesel = :pesel");
        }

        if(isset($contractorData["nip"]))
        {
            $params[":nip"] = $contractorData["nip"];
            array_push($columnNames, "nip = :nip");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.contractors SET ".$columnNamesStr." WHERE idcontractor = :idcontractor";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
    }

    public function deleteContractors(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.contractors WHERE idcontractor IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }
}