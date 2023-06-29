<?php

class Documentdefinition implements JsonSerializable
{
    private $iddocumentdefinition;
    private $name;
    private $symbol;
    private $direction;
    private $directionName;
    private $type;
    private $typeName;
    private $description;

    public function __construct(int $iddocumentdefinition, string $name, string $symbol, int $direction, int $type, string $description)
    {
        $this->iddocumentdefinition = $iddocumentdefinition;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->direction = $direction;
        $this->directionName = $this->getDirectionNameValue($direction);
        $this->type = $type;
        $this->typeName = $this->getTypeNameValue($type);
        $this->description = $description;
    }

    private function getDirectionNameValue(?int $direction): string
    {
        switch ($direction)
        {
            case 2:
                return "income";
            case 3:
                return "expenditure";
            case 1:
            default:
                return "";
        }
        return "";
    }

    private function getTypeNameValue(?int $type): string
    {
        switch ($type)
        {
            case 1:
                return "offer";
            case 2:
                return "sale";
            case 3:
                return "warehouse";
            default:
                return "";
        }
        return "";
    }

    public function getIddocumentdefinition()
    {
        return $this->iddocumentdefinition;
    }

    public function setIddocumentdefinition(int $iddocumentdefinition): void
    {
        $this->iddocumentdefinition = $iddocumentdefinition;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol($symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }

    public function setDirection(int $direction): void
    {
        $this->direction = $direction;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDirectionName(): string
    {
        return $this->directionName;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}