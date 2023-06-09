<?php

require_once "Repository.php";

// Models
require_once __DIR__."/../models/Address.php";

class AddressesRepository extends Repository
{
    public function getFirstAddresses(int $limit): array
    {
        $query = "SELECT * FROM trader.addresses LIMIT :limit";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $addressesData = $stmt->fetchAll();

        $addresses = [];
        foreach($addressesData as $addressData)
        {
            $address = new Address(
                $addressData["idaddress"],
                $addressData["city"],
                $addressData["street"],
                $addressData["homenumber"],
                $addressData["localnumber"],
                $addressData["zipcode"]
            );

            array_push($addresses, $address);
        }
        return $addresses;
    }

    public function getAddressById(int $id): ?Address
    {
        $query = "SELECT * FROM trader.addresses WHERE idaddress = :idaddress";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":idaddress", $id, PDO::PARAM_INT);
        $stmt->execute();

        $address = $stmt->fetch(PDO::FETCH_ASSOC);
        if($address == false)
        {
            return null;
        }

        return new Address(
            $address["idaddress"],
            $address["city"],
            $address["street"],
            $address["homenumber"],
            $address["localnumber"],
            $address["zipcode"]
        );
    }

    public function getAddress(string $city, string $street, string $homenumber, string $localnumber, string $zipcode): ?Address
    {
        $query = "SELECT * FROM trader.addresses WHERE city = :city AND street = :street AND homenumber = :homenumber AND localnumber = :localnumber AND zipcode = :zipcode LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":city", $city, PDO::PARAM_STR);
        $stmt->bindParam(":street", $street, PDO::PARAM_STR);
        $stmt->bindParam(":homenumber", $homenumber, PDO::PARAM_STR);
        $stmt->bindParam(":localnumber", $localnumber, PDO::PARAM_STR);
        $stmt->bindParam(":zipcode", $zipcode, PDO::PARAM_STR);
        $stmt->execute();

        $address = $stmt->fetch(PDO::FETCH_ASSOC);
        if($address == false)
        {
            return null;
        }

        return new Address(
            $address["idaddress"],
            $address["city"],
            $address["street"],
            $address["homenumber"],
            $address["localnumber"],
            $address["zipcode"]
        );
    }

    public function createAddress(Address $address) : int
    {
        $query = "INSERT INTO trader.addresses VALUES (DEFAULT, :city, :street, :homenumber, :localnumber, :zipcode) RETURNING idaddress";

        $city = $address->getCity();
        $street = $address->getStreet();
        $homenumber = $address->getHomenumber();
        $localnumber = $address->getLocalnumber();
        $zipcode = $address->getZipcode();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":city", $city, PDO::PARAM_STR);
        $stmt->bindParam(":street", $street, PDO::PARAM_STR);
        $stmt->bindParam(":homenumber", $homenumber, PDO::PARAM_STR);
        $stmt->bindParam(":localnumber", $localnumber, PDO::PARAM_STR);
        $stmt->bindParam(":zipcode", $zipcode, PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows[0]["idaddress"];
    }

    public function updateAddress(int $idaddress, array $addressData) : void
    {
        $columnNames = array();
        $params = array();
        $params[":idaddress"] = $idaddress;

        if(isset($addressData["city"]))
        {
            $params[":city"] = $addressData["city"];
            array_push($columnNames, "city = :city");
        }

        if(isset($addressData["homenumber"]))
        {
            $params[":homenumber"] = $addressData["homenumber"];
            array_push($columnNames, "homenumber = :homenumber");
        }

        if(isset($addressData["localnumber"]))
        {
            $params[":localnumber"] = $addressData["localnumber"];
            array_push($columnNames, "localnumber = :localnumber");
        }

        if(isset($addressData["street"]))
        {
            $params[":street"] = $addressData["street"];
            array_push($columnNames, "street = :street");
        }

        if(isset($addressData["zipcode"]))
        {
            $params[":zipcode"] = $addressData["zipcode"];
            array_push($columnNames, "zipcode = :zipcode");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.addresses SET ".$columnNamesStr." WHERE idaddress = :idaddress";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
    }
}