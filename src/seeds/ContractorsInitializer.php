<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Contractor.php";

// Services
require_once __DIR__."/../services/ContractorsService.php";
require_once __DIR__."/../services/AddressesService.php";

class ContractorsInitializer implements IInitializer
{
    private static $contractorsData = [
        [
            "companyname" => "Firma 1",
            "nip" => "9999999999",
            "pesel" => null
        ],
        [
            "companyname" => "Firma 2",
            "nip" => "8888888888",
            "pesel" => null
        ],
        [
            "companyname" => "Prywatna osoba 1",
            "nip" => null,
            "pesel" => "11111111111",
        ]
    ];

    private $contractorsService;
    private $addressesService;

    public function __construct()
    {
        $this->contractorsService = new ContractorsService();
        $this->addressesService = new AddressesService();
    }

    public function initialize(): void
    {
        $addresses = $this->addressesService->getFirstAddresses(3);

        $i = 0;
        foreach (self::$contractorsData as $contractorData)
        {
            $address = $addresses[$i];

            $contractor = new Contractor(
                0,
                $contractorData["companyname"],
                $contractorData["nip"],
                $contractorData["pesel"],
                $address->getIdaddress(),
                null
            );

            $this->contractorsService->createContractorIfNotExists($contractor);

            if($i < 3)
            {
                $i++;
            }
            else
            {
                $i = 0;
            }
        }
    }
}