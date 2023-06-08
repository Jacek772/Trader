<?php

class Document
{
    private $idDocument;
    private $date;
    private $number;
    private $state;
    private $description;
    private $idDefinition;
    private $idContractor;
    private $idWarehouse;
    private $idCurrency;
    private $definition;
    private $positions;

    public function __construct(int $idDocument, string $date, string $number, int $state, string $description, int $idDefinition, int $idContractor, int $idWarehouse, int $idCurrency)
    {
        $this->idDocument = $idDocument;
        $this->date = $date;
        $this->number = $number;
        $this->state = $state;
        $this->description = $description;
        $this->idDefinition = $idDefinition;
        $this->idContractor = $idContractor;
        $this->idWarehouse = $idWarehouse;
        $this->idCurrency = $idCurrency;
    }

    public function getIdDocument(): int
    {
        return $this->idDocument;
    }

    public function setIdDocument(int $idDocument): void
    {
        $this->idDocument = $idDocument;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIdDefinition(): int
    {
        return $this->idDefinition;
    }

    public function setIdDefinition(int $idDefinition): void
    {
        $this->idDefinition = $idDefinition;
    }

    public function getIdContractor(): int
    {
        return $this->idContractor;
    }

    public function setIdContractor(int $idContractor): void
    {
        $this->idContractor = $idContractor;
    }

    public function getIdWarehouse(): int
    {
        return $this->idWarehouse;
    }

    public function setIdWarehouse(int $idWarehouse): void
    {
        $this->idWarehouse = $idWarehouse;
    }

    public function getIdCurrency(): int
    {
        return $this->idCurrency;
    }

    public function setIdCurrency(int $idCurrency): void
    {
        $this->idCurrency = $idCurrency;
    }

    public function getDefinition(): Documentdefinition
    {
        return $this->definition;
    }

    public function setDefinition(int $definition): void
    {
        $this->definition = $definition;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }
}