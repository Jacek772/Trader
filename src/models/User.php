<?php

class User
{
    private $idUser;
    private $idRole;
    private $name;
    private $surname;
    private $login;
    private $password;

    public function __construct(string $idUser, int $idRole, string $name, string $surname, string $login, string $password, bool $enabled = true)
    {
        $this->idUser = $idUser;
        $this->idRole = $idRole;
        $this->name = $name;
        $this->surname = $surname;
        $this->login = $login;
        $this->password = $password;
        $this->enabled = $enabled;
    }

    public function getIdUser(): string
    {
        return $this->idUser;
    }

    public function setIdUser(string $idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdRole(): int
    {
        return $this->idRole;
    }

    public function setIdRole(int $idRole)
    {
        $this->idRole = $idRole;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}