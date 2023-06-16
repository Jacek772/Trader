<?php

class Unit implements JsonSerializable
{
    private $idunit;
    private $symbol;

    public function __construct(int $idunit, string $symbol)
    {
        $this->idunit = $idunit;
        $this->symbol = $symbol;
    }

    public function getIdunit(): int
    {
        return $this->idunit;
    }

    public function setIdunit(int $idunit): void
    {
        $this->idunit = $idunit;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}