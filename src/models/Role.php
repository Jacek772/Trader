<?php

class Role implements JsonSerializable
{
    private $idRole;
    private $name;
    private $description;

    public function __construct(int $idRole, string $name, string $description)
    {
        $this->idRole = $idRole;
        $this->name = $name;
        $this->description = $description;
    }

    public function getIdRole(): int
    {
        return $this->idRole;
    }

    public function setIdRole(int $idRole): void
    {
        $this->idRole = $idRole;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription()
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