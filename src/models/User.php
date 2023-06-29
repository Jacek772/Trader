<?php

class User implements JsonSerializable
{
    private $iduser;
    private $idrole;
    private $name;
    private $surname;
    private $login;
    private $password;

    private $role;

    public function __construct(string $iduser, int $idrole, string $name, string $surname, string $login, string $password, bool $enabled = true)
    {
        $this->iduser = $iduser;
        $this->idrole = $idrole;
        $this->name = $name;
        $this->surname = $surname;
        $this->login = $login;
        $this->password = $password;
        $this->enabled = $enabled;
    }

    public function getIdUser(): string
    {
        return $this->iduser;
    }

    public function setIdUser(string $iduser)
    {
        $this->iduser = $iduser;
    }

    public function getIdRole(): int
    {
        return $this->idrole;
    }

    public function setIdRole(int $idrole)
    {
        $this->idrole = $idrole;
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

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}