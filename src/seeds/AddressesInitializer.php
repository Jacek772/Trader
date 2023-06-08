<?php

// Interfaces
require_once "abstracts/IInitializer.php";

// Models
require_once __DIR__."/../models/Address.php";

// Services
require_once __DIR__."/../services/AddressesService.php";

class AddressesInitializer implements IInitializer
{
    private static $addressesData = [
        [
          "city" => "Kraków",
          "street" => "Dietla",
          "homenumber" => "56",
          "localnumber" => "12",
          "zipcode" => "12-345"
        ],
        [
            "city" => "Warszawa",
            "street" => "Powstańców Śląskich",
            "homenumber" => "33",
            "localnumber" => "22",
            "zipcode" => "36-777"
        ],
        [
            "city" => "Poznań",
            "street" => "Kolejowa",
            "homenumber" => "123",
            "localnumber" => "321",
            "zipcode" => "67-999"
        ],
        [
            "city" => "Gdańsk",
            "street" => "Morska",
            "homenumber" => "67",
            "localnumber" => "33",
            "zipcode" => "45-901"
        ]
    ];

    private $addressesService;

    public function __construct()
    {
        $this->addressesService = new AddressesService();
    }

    public function initialize(): void
    {
        foreach (self::$addressesData as $addressData)
        {
            $address = new Address(
                0,
                $addressData["city"],
                $addressData["street"],
                $addressData["homenumber"],
                $addressData["localnumber"],
                $addressData["zipcode"]
            );

            $this->addressesService->createAddressIfNotExists($address);
        }
    }
}