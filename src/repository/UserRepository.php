<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/User.php";

class UserRepository extends Repository
{
    public function getAllUsers(): array
    {
        $query = "SELECT u.iduser, u.name u_name, u.surname u_surname, u.login u_login, u.enabled u_enabled,
                    r.idrole, r.name r_name, r.description r_description
                    FROM trader.users u
                    INNER JOIN trader.roles r ON r.idrole = u.idrole";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute();

        $usersData = $stmt->fetchAll();
        if(!$usersData)
        {
            return [];
        }

        $users = [];
        foreach ($usersData as $userData)
        {
            $user = new User(
                $userData["iduser"],
                $userData["idrole"],
                $userData["u_name"],
                $userData["u_surname"],
                $userData["u_login"],
                "",
                $userData["u_enabled"]
            );

            $role = new Role(
                $userData["idrole"],
                $userData["r_name"],
                $userData["r_description"]
            );

            $user->setRole($role);

            array_push($users, $user);
        }
        return $users;
    }

    public function getUsers(?int $idrole = null): array
    {
        $query = "SELECT u.iduser, u.name u_name, u.surname u_surname, u.login u_login, u.enabled u_enabled,
                    r.idrole, r.name r_name, r.description r_description
                    FROM trader.users u
                    INNER JOIN trader.roles r ON r.idrole = u.idrole";


        $queryParts = [];
        $filters = [];

        if($idrole)
        {
            array_push($queryParts, "r.idrole = ?");
            array_push($filters, $idrole);
        }

        if(count($filters) > 0)
        {
            $query = $query." WHERE ".join(" AND ", $queryParts);
        }

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($filters);
        $usersData = $stmt->fetchAll();
        if(!$usersData)
        {
            return [];
        }

        $users = [];
        foreach ($usersData as $userData)
        {
            $user = new User(
                $userData["iduser"],
                $userData["idrole"],
                $userData["u_name"],
                $userData["u_surname"],
                $userData["u_login"],
                "",
                $userData["u_enabled"]
            );

            $role = new Role(
                $userData["idrole"],
                $userData["r_name"],
                $userData["r_description"]
            );

            $user->setRole($role);

            array_push($users, $user);
        }
        return $users;
    }

    public function getUserById(int $iduser): ?User
    {
        $query = "SELECT u.iduser, u.name u_name, u.surname u_surname, u.login u_login, u.password u_password, u.enabled u_enabled,
                    r.idrole, r.name r_name, r.description r_description
                    FROM trader.users u
                    INNER JOIN trader.roles r ON r.idrole = u.idrole
                    WHERE iduser = :iduser";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":iduser", $iduser, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$userData)
        {
            return null;
        }

        $user = new User(
            $userData["iduser"],
            $userData["idrole"],
            $userData["u_name"],
            $userData["u_surname"],
            $userData["u_login"],
            $userData["u_password"],
            $userData["u_enabled"]
        );

        $role = new Role(
            $userData["idrole"],
            $userData["r_name"],
            $userData["r_description"]
        );

        $user->setRole($role);

        return $user;
    }

    public function getUser(string $login): ?User
    {
        $query = "SELECT u.iduser, u.name u_name, u.surname u_surname, u.login u_login, u.password u_password, u.enabled u_enabled,
                    r.idrole, r.name r_name, r.description r_description
                    FROM trader.users u
                    INNER JOIN trader.roles r ON r.idrole = u.idrole WHERE login = :login";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$userData)
        {
            return null;
        }

        $user = new User(
            $userData["iduser"],
            $userData["idrole"],
            $userData["u_name"],
            $userData["u_surname"],
            $userData["u_login"],
            $userData["u_password"],
            $userData["u_enabled"]
        );

        $role = new Role(
            $userData["idrole"],
            $userData["r_name"],
            $userData["r_description"]
        );

        $user->setRole($role);

        return $user;
    }

    public function createUser(User $user): void
    {
        $query = "INSERT INTO trader.users VALUES (DEFAULT, :name, :surname, :login, :password, :enabled, :idrole)";

        $name = $user->getName();
        $surname = $user->getSurname();
        $login = $user->getLogin();
        $password = $user->getPassword();
        $enabled = $user->isEnabled();
        $idrole = $user->getIdRole();

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":enabled", $enabled, PDO::PARAM_BOOL);
        $stmt->bindParam(":idrole", $idrole, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateUser(int $iduser, array $userData): void
    {
        $columnNames = array();
        $params = array();
        $params[":iduser"] = $iduser;

        if(isset($userData["name"]))
        {
            $params[":name"] = $userData["name"];
            array_push($columnNames, "name = :name");
        }

        if(isset($userData["surname"]))
        {
            $params[":surname"] = $userData["surname"];
            array_push($columnNames, "surname = :surname");
        }

        if(isset($userData["login"]))
        {
            $params[":login"] = $userData["login"];
            array_push($columnNames, "login = :login");
        }

        if(isset($userData["password"]))
        {
            $params[":password"] = $userData["password"];
            array_push($columnNames, "password = :password");
        }

        if(isset($userData["enabled"]))
        {
            $params[":enabled"] = $userData["enabled"];
            array_push($columnNames, "enabled = :enabled");
        }

        if(isset($userData["idrole"]))
        {
            $params[":idrole"] = $userData["idrole"];
            array_push($columnNames, "idrole = :idrole");
        }

        $columnNamesStr = implode(", ", $columnNames);
        if(count($columnNames) == 0)
        {
            return;
        }

        $query = "UPDATE trader.users SET ".$columnNamesStr." WHERE iduser = :iduser";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($params);
    }

    public function deleteUsers(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "DELETE FROM trader.users WHERE iduser IN ($in)";
        $stmt = $this->databse->connect()->prepare($query);
        $stmt->execute($ids);
    }
}