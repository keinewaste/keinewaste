<?php

namespace KeineWaste\Services\Repository;


use KeineWaste\Dto\User;
use Psr\Log\LoggerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;


class UserRepository
{
    use LoggerAwareTrait;

    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * UsersRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @param array $params
     *
     * @return User
     */
    public function getUser(array $params)
    {
        $repository = $this->entityManager->getRepository(User::class);
        return $repository->findOneBy($params);
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        $repository = $this->entityManager->getRepository(User::class);
        return $repository->findAll();
    }
}