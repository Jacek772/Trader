<?php

//
require_once "Repository.php";

// Models
require_once __DIR__."/../models/User.php";

class UserRepository extends Repository
{
    public function getUser(string $login): ?User
    {
        $query = "SELECT * FROM trader.users WHERE login = :login";

        $stmt = $this->databse->connect()->prepare($query);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user)
        {
            return null;
        }

        return new User(
            $user["iduser"],
            $user["idrole"],
            $user["name"],
            $user["surname"],
            $user["login"],
            $user["password"],
            $user["enabled"]
        );
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
}