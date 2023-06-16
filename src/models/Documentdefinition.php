<?php

class Documentdefinition implements JsonSerializable
{
    private $idDocumentdefinition;
    private $name;
    private $symbol;
    private $direction;
    private $type;
    private $description;

    public function __construct(int $idDocumentdefinition, string $name, string $symbol, int $direction, int $type, string $description)
    {
        $this->idDocumentdefinition = $idDocumentdefinition;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->direction = $direction;
        $this->type = $type;
        $this->description = $description;
    }

    public function getIdDocumentdefinition()
    {
        return $this->idDocumentdefinition;
    }

    public function setIdDocumentdefinition(int $idDocumentdefinition): void
    {
        $this->idDocumentdefinition = $idDocumentdefinition;
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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}