<?php

//
require_once "AppController.php";

// Services
require_once __DIR__."/../services/ContractorsService.php";
require_once __DIR__."/../services/AddressesService.php";

class ContractorsController extends AppController
{
    private $contractorsService;
    private $addressesService;

    public function __construct()
    {
        parent::__construct();
        $this->contractorsService = new ContractorsService();
        $this->addressesService = new AddressesService();
    }

    public function all()
    {
        try {
            $data = ["contractors" => $this->contractorsService->getAllContractors()];
            echo json_encode($data, true);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function create()
    {
        try {
            // Address
            $city = $_POST["city"];
            $homenumber = $_POST["homenumber"];
            $localnumber = $_POST["localnumber"];
            $street = $_POST["street"];
            $zipcode = $_POST["zipcode"];

            $address = new Address(
                0,
                $city,
                $homenumber,
                $localnumber,
                $street,
                $zipcode
            );

            $idaddress = $this->addressesService->createAddress($address);

            // Contractor
            $companyname = $_POST["companyname"];
            $nip = null;
            if(isset($_POST["nip"]) && $_POST["nip"] != "null")
            {
                $nip = $_POST["nip"];
            }

            $pesel = null;
            if(isset($_POST["pesel"]) && $_POST["pesel"] != "null")
            {
                $pesel = $_POST["pesel"];
            }

            $iduser = null;
            if(isset($_POST["iduser"]) && $_POST["iduser"] != "null")
            {
                $iduser = $_POST["iduser"];
            }

            $contractor = new Contractor(
                0,
                $companyname,
                $nip,
                $pesel,
                $idaddress,
                $iduser
            );

            $this->contractorsService->createContractor($contractor);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {
            // Contractor
            $idcontractor = $_POST["idcontractor"];
            $contractorData = [
                "companyname" => $_POST["companyname"],
                "pesel" => $_POST["pesel"],
                "nip" => $_POST["nip"]
            ];
            $this->contractorsService->updateContractor($idcontractor, $contractorData);

            // Address
            $idaddress = $_POST["idaddress"];
            $addressData = [
                "city" => $_POST["city"],
                "homenumber" => $_POST["homenumber"],
                "localnumber" => $_POST["localnumber"],
                "street" => $_POST["street"],
                "zipcode" => $_POST["zipcode"]
            ];
            $this->addressesService->updateAddress($idaddress, $addressData);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }

    public function remove()
    {
        try {
            $idsStr = $_POST["ids"];
            $ids = preg_split ("/\,/", $idsStr);
            $this->contractorsService->deleteContractors($ids);
        }
        catch (Exception $e)
        {
            header("HTTP/1.1 500 Internal Server Error");
            echo $e->getMessage();
        }
    }
}
