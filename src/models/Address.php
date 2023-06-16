<?php

class Address implements JsonSerializable
{
    private $idaddress;
    private $city;
    private $street;
    private $homenumber;
    private $localnumber;
    private $zipcode;

    public function __construct(int $idaddress, string $city, string $street, string $homenumber, string $localnumber, string $zipcode)
    {
        $this->idaddress = $idaddress;
        $this->city = $city;
        $this->street = $street;
        $this->homenumber = $homenumber;
        $this->localnumber = $localnumber;
        $this->zipcode = $zipcode;
    }

    public function getIdaddress(): int
    {
        return $this->idaddress;
    }

    public function setIdaddress(int $idaddress): void
    {
        $this->idaddress = $idaddress;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getHomenumber(): string
    {
        return $this->homenumber;
    }

    public function setHomenumber(string $homenumber): void
    {
        $this->homenumber = $homenumber;
    }

    public function getLocalnumber(): string
    {
        return $this->localnumber;
    }

    public function setLocalnumber(string $localnumber): void
    {
        $this->localnumber = $localnumber;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}