<?php

// Repositories
require_once __DIR__."/../repository/AddressesRepository.php";

class AddressesService
{
    private $addressesRepository;

    public function __construct()
    {
        $this->addressesRepository = new AddressesRepository();
    }

    public function createAddressIfNotExists(Address $address): void
    {
        if(!$this->existsAddress($address))
        {
            $this->createAddress($address);
        }
    }

    public function getFirstAddresses(int $limit): array
    {
        return $this->addressesRepository->getFirstAddresses($limit);
    }

    public function getAddressById(int $id): ?Address
    {
        return $this->addressesRepository->getAddressById($id);
    }

    public function getAddress(string $city, string $street, string $homenumber, string $localnumber, string $zipcode): ?Address
    {
        return $this->addressesRepository->getAddress($city, $street, $homenumber, $localnumber, $zipcode);
    }

    public function createAddress(Address $address) : int
    {
        return $this->addressesRepository->createAddress($address);
    }

    // $addressData = []
    public function updateAddress(int $idaddress, array $addressData): void
    {
        $this->addressesRepository->updateAddress($idaddress, $addressData);
    }

    public function existsAddress(Address $address) : bool
    {
        $address = $this->getAddress(
            $address->getCity(),
            $address->getStreet(),
            $address->getHomenumber(),
            $address->getLocalnumber(),
            $address->getZipcode()
        );
        return $address != null;
    }
}