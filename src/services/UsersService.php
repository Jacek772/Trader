<?php

// Repositories
require_once __DIR__."/../repository/UserRepository.php";

class UsersService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function createUserIfNotExists(User $user):void
    {
        if(!$this->existsUser($user->getLogin()))
        {
            $this->createUser($user);
        }
    }

    public function createUser(User $user): void
    {
        $hash = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $this->userRepository->createUser($user);
    }

    public function existsUser(?string $login): bool
    {
        if(!$login)
        {
            return false;
        }

        $user = $this->getUser($login);
        return $user != null;
    }

    public function getUser(?string $login): ?User
    {
        if(!$login)
        {
            return null;
        }
        return $this->userRepository->getUser($login);
    }
}