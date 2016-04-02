<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\UserService;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController
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
     * @param Request $request
     *
     * @return JsonResponse
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function getAction(Request $request)
    {

        $id = $request->get('id');

        if ($id == 'me') {
            $user = $this->getLoggedUser($request, false);
        } else {
            $user = $this->userService->getUserById($id);
        }

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        return $this
            ->getResponse()
            ->setData(
                $user
            );
    }

    public function updateAction(Request $request)
    {
        $user = $this->getLoggedUser($request, false);

        $requestContent = $request->getContent();

        $requestData = json_decode($requestContent, true);

        if ($requestData == null || !is_array($requestData)) {
            throw new BadRequestHttpException();
        }

        $this->userService->updateUser($user, $requestData);

        return $this
            ->getResponse()
            ->setData(
                $user
            )
            ->setStatusCode(201);
    }
}