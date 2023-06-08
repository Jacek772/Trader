<?php

class Warehouse
{
    private $idwarehouse;
    private $symbol;
    private $name;
    private $description;
    private $idaddress;

    public function __construct(int $idwarehouse, string $symbol, string $name, string $description, int $idaddress)
    {
        $this->idwarehouse = $idwarehouse;
        $this->symbol = $symbol;
        $this->name = $name;
        $this->description = $description;
        $this->idaddress = $idaddress;
    }

    public function getIdwarehouse(): int
    {
        return $this->idwarehouse;
    }

    public function setIdwarehouse(int $idwarehouse): void
    {
        $this->idwarehouse = $idwarehouse;
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

    public function getIdaddress(): int
    {
        return $this->idaddress;
    }

    public function setIdaddress(int $idaddress): void
    {
        $this->idaddress = $idaddress;
    }
}