<?php

class Document implements JsonSerializable
{
    private $iddocument;
    private $date;
    private $number;
    private $state;
    private $description;
    private $iddefinition;
    private $idcontractor;
    private $idwarehouse;
    private $idcurrency;


    private $definition;
    private $currency;
    private $contractor;
    private $warehouse;
    private $positions;

    private $valueNetto = 0;
    private $valueVat = 0;
    private $valueGross = 0;

    public function __construct(int $iddocument, string $date, string $number, int $state, string $description, int $iddefinition, int $idcontractor, int $idwarehouse, int $idcurrency)
    {
        $this->iddocument = $iddocument;
        $this->date = $date;
        $this->number = $number;
        $this->state = $state;
        $this->description = $description;
        $this->iddefinition = $iddefinition;
        $this->idcontractor = $idcontractor;
        $this->idwarehouse = $idwarehouse;
        $this->idcurrency = $idcurrency;
        $this->calculateValues();
    }

    public function getIddocument(): int
    {
        return $this->iddocument;
    }

    public function setIdDocument(int $iddocument): void
    {
        $this->iddocument = $iddocument;
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

    public function getIddefinition(): int
    {
        return $this->iddefinition;
    }

    public function setIddefinition(int $iddefinition): void
    {
        $this->iddefinition = $iddefinition;
    }

    public function getIdcontractor(): int
    {
        return $this->idcontractor;
    }

    public function setIdcontractor(int $idcontractor): void
    {
        $this->idcontractor = $idcontractor;
    }

    public function getIdwarehouse(): int
    {
        return $this->idwarehouse;
    }

    public function setIdWarehouse(int $idwarehouse): void
    {
        $this->idwarehouse = $idwarehouse;
    }

    public function getIdcurrency(): int
    {
        return $this->idcurrency;
    }

    public function setIdcurrency(int $idcurrency): void
    {
        $this->idcurrency = $idcurrency;
    }

    public function getDefinition(): Documentdefinition
    {
        return $this->definition;
    }

    public function setDefinition(Documentdefinition $definition): void
    {
        $this->definition = $definition;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getContractor(): Contractor
    {
        return $this->contractor;
    }

    public function setContractor(Contractor $contractor): void
    {
        $this->contractor = $contractor;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
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
        $this->valueNetto = 0;
        $this->valueVat = 0;
        $this->valueGross = 0;

        if($this->positions)
        {
            foreach ($this->positions as $position)
            {
                $this->valueNetto += $position->getValueNetto();
                $this->valueVat += $position->getValueVat();
                $this->valueGross += $position->getValueGross();
            }

            $this->valueNetto = round($this->valueNetto, 2);
            $this->valueVat = round($this->valueVat, 2);
            $this->valueGross = round($this->valueGross, 2);
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}