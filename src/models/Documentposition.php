<?php

class Documentposition
{
    private $iddocumentposition;
    private $quantity;
    private $price;
    private $iddocument;
    private $idcommodity;
    private $idvatrate;

    public function __construct(int $iddocumentposition, float $quantity, float $price, int $iddocument, int $idcommodity, int $idvatrate)
    {
        $this->iddocumentposition = $iddocumentposition;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->iddocument = $iddocument;
        $this->idcommodity = $idcommodity;
        $this->idvatrate = $idvatrate;
    }

    public function getIddocumentposition()
    {
        return $this->iddocumentposition;
    }

    public function setIddocumentposition($iddocumentposition): void
    {
        $this->iddocumentposition = $iddocumentposition;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getIddocument(): int
    {
        return $this->iddocument;
    }

    public function setIddocument(int $iddocument): void
    {
        $this->iddocument = $iddocument;
    }

    public function getIdcommodity(): int
    {
        return $this->idcommodity;
    }

    public function setIdcommodity(int $idcommodity): void
    {
        $this->idcommodity = $idcommodity;
    }

    public function getIdvatrate(): int
    {
        return $this->idvatrate;
    }

    public function setIdvatrate(int $idvatrate): void
    {
        $this->idvatrate = $idvatrate;
    }


}