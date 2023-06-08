<?php

require_once __DIR__."/../repository/UserRepository.php";

class AuthService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login(?string $login, ?string $password)
    {
        if(!$login || !$password)
        {
            return ["success" => false, "messages" => ["User not exists!"]];
        }

        $user = $this->userRepository->getUser($login);
        if(!$user)
        {
            return ["success" => false, "messages" => ["User not exists!"]];
        }

        if($user->getLogin() !== $login)
        {
            return ["success" => false, "messages" => ["User with this login not exists!"]];
        }

        if(!password_verify($password, $user->getPassword()))
        {
            return ["success" => false, "messages" => ["Bad password!"]];
        }
        return ["success" => true, "user" => $user ];
    }
}