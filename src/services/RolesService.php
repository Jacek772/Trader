<?php

// Repositories
require_once __DIR__."/../repository/RolesRepository.php";

class RolesService
{
    private $rolesRepository;

    public function __construct()
    {
        $this->rolesRepository = new RolesRepository();
    }

    public function createRoleIfNotExists(Role $role): void
    {
        if(!$this->existsRole($role->getName()))
        {
            $this->createRole($role);
        }
    }

    public function createRole(Role $role): void
    {
        $this->rolesRepository->createRole($role);
    }

    public function existsRole(?string $name): bool
    {
        if(!$name)
        {
            return false;
        }

        $role = $this->getRole($name);
        return $role != null;
    }

    public function getRole(?string $name): ?Role
    {
        return $this->rolesRepository->getRole($name);
    }
}