<?php

namespace KeineWaste\Services\Repository;


use Psr\Log\LoggerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use KeineWaste\Dto\Message;


class MessageRepository
{
    use LoggerAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Doctrine constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Message $message)
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        return true;
    }
}