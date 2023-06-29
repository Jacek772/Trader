<?php

class Documentposition implements JsonSerializable
{
    private $iddocumentposition;
    private $quantity;
    private $price;
    private $iddocument;
    private $idcommodity;
    private $idvatrate;

    private $commodity;
    private $vatrate;

    private $valueNetto = 0;
    private $valueVat = 0;
    private $valueGross = 0;

    public function __construct(int $iddocumentposition, float $quantity, float $price, int $iddocument, int $idcommodity, int $idvatrate)
    {
        $this->iddocumentposition = $iddocumentposition;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->iddocument = $iddocument;
        $this->idcommodity = $idcommodity;
        $this->idvatrate = $idvatrate;
        $this->calculateValues();
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
        $this->calculateValues();
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
        $this->calculateValues();
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

    public function getCommodity(): Commodity
    {
        return $this->commodity;
    }

    public function setCommodity(Commodity $commodity): void
    {
        $this->commodity = $commodity;
    }

    public function getVatrate(): Vatrate
    {
        return $this->vatrate;
    }

    public function setVatrate(Vatrate $vatrate): void
    {
        $this->vatrate = $vatrate;
        $this->calculateValues();
    }

    public function getValueNetto(): float
    {
        return $this->valueNetto;
    }

    public function getValueVat(): float
    {
        return $this->valueVat;
    }

    public function getValueGross(): float
    {
        return $this->valueGross;
    }

    private function calculateValues(): void
    {
        $this->valueNetto = round($this->quantity * $this->price, 2);
        if($this->vatrate)
        {
            $this->valueVat = round($this->valueNetto * $this->vatrate->getPercent(), 2);
            $this->valueGross = $this->valueNetto + $this->valueVat;
        }
        else
        {
            $this->valueVat = 0;
            $this->valueGross = $this->valueNetto;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}