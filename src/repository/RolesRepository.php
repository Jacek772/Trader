<?php

require_once "Repository.php";
require_once __DIR__."/../models/Role.php";

class RolesRepository extends Repository
{
    public function getRole(string $name): ?Role
    {
        $query = "SELECT * FROM trader.roles WHERE name = :name LIMIT 1";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        if($role == false)
        {
            return null;
        }
        return new Role(
            $role["idrole"],
            $role["name"],
            $role["description"]
        );
    }

    public function createRole(Role $role): void
    {
        $query = "INSERT INTO trader.roles VALUES (DEFAULT, :name, :description)";

        $name = $role->getName();
        $description = $role->getDescription();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->execute();
    }
}