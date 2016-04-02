<?php


namespace KeineWaste\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use KeineWaste\Controllers\Base\BaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{
    use BaseTrait;

    /** @var EntityManagerInterface $em */
    protected $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Users action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAction(Request $request)
    {
        $userRepository = $this->em->getRepository('KeineWaste\Dto\User');
        $users = $userRepository->findAll();

        return $this
            ->getResponse()
            ->setData($users);
    }
}