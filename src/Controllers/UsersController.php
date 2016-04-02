<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\UserService;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{
    use BaseTrait;
    use LoggerAwareTrait;

    /**
     * @var UserService
     */
    protected $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        return $this
            ->getResponse()
            ->setData($this->userService->getUsers());
    }
}