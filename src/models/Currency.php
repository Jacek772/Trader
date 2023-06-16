<?php

class Currency implements JsonSerializable
{
    private $idcurrency;
    private $symbol;
    private $name;

    public function __construct(int $idcurrency, string $symbol, string $name)
    {
        $this->idcurrency = $idcurrency;
        $this->symbol = $symbol;
        $this->name = $name;
    }

    public function getIdcurrency(): int
    {
        return $this->idcurrency;
    }

    public function setIdcurrency(int $idcurrency): void
    {
        $this->idcurrency = $idcurrency;
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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}