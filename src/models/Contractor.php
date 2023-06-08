<?php

class Contractor
{
    private $idcontractor;
    private $companyname;
    private $nip;
    private $pesel;
    private $idaddress;
    private $iduser;

    public function __construct(int $idcontractor, string $companyname, ?string $nip, ?string $pesel, int $idaddress, ?int $iduser)
    {
        $this->idcontractor = $idcontractor;
        $this->companyname = $companyname;
        $this->nip = $nip;
        $this->pesel = $pesel;
        $this->idaddress = $idaddress;
        $this->iduser = $iduser;
    }

    public function getIdcontractor(): int
    {
        return $this->idcontractor;
    }

    public function setIdcontractor(int $idcontractor): void
    {
        $this->idcontractor = $idcontractor;
    }

    public function getCompanyname(): string
    {
        return $this->companyname;
    }

    public function setCompanyname(string $companyname): void
    {
        $this->companyname = $companyname;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(?string $nip): void
    {
        $this->nip = $nip;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): void
    {
        $this->pesel = $pesel;
    }

    public function getIdaddress(): int
    {
        return $this->idaddress;
    }

    public function setIdaddress(int $idaddress): void
    {
        $this->idaddress = $idaddress;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): void
    {
        $this->iduser = $iduser;
    }


}