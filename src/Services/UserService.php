<?php
namespace KeineWaste\Services;

use KeineWaste\Dto\User as DtoUser;
use KeineWaste\Services\Repository\UserRepository;
use Psr\Log\LoggerAwareTrait;

class UserService
{

    use LoggerAwareTrait;

    /**
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserById($id)
    {
        return $this->getUser(['id' => $id]);
    }

    public function getUserByUsername($username)
    {
        return $this->getUser(['username' => $username]);
    }

    public function getUserByMail($email)
    {
        return $this->getUser(['email' => $email]);

    }

    /**
     * @param array $array
     *
     * @returns DtoUser
     */
    protected function getUser(array $array)
    {
        $user = $this->repository->getUser($array);
        return $user;
    }

    /**
     *
     * @returns DtoUser[]
     */
    public function getUsers()
    {
        $user = $this->repository->getUsers();
        return $user;
    }


}

