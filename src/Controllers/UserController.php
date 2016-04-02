<?php


namespace KeineWaste\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use KeineWaste\Controllers\Base\BaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UserController
{
    use BaseTrait;

    /** @var EntityManagerInterface $em */
    protected $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * User action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAction(Request $request)
    {
        $user = $this->em->find('KeineWaste\Dto\User', 3);

        return $this
            ->getResponse()
            ->setData($user);
    }
}