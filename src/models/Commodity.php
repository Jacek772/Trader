<?php

class Commodity implements JsonSerializable
{
    private $idcommodity;
    private $symbol;
    private $name;
    private $description;
    private $idunit;
    private $idvatrate;

    public function __construct(int $idcommodity, string $symbol, string $name, string $description, int $idunit, int $idvatrate)
    {
        $this->idcommodity = $idcommodity;
        $this->symbol = $symbol;
        $this->name = $name;
        $this->description = $description;
        $this->idunit = $idunit;
        $this->idvatrate = $idvatrate;
    }

    public function getIdcommodity(): int
    {
        return $this->idcommodity;
    }

    public function setIdcommodity(int $idcommodity): void
    {
        $this->idcommodity = $idcommodity;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIdunit(): int
    {
        return $this->idunit;
    }

    public function setIdunit(int $idunit): void
    {
        $this->idunit = $idunit;
    }

    public function getIdvatrate(): int
    {
        return $this->idvatrate;
    }

    public function setIdvatrate(int $idvatrate): void
    {
        $this->idvatrate = $idvatrate;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}