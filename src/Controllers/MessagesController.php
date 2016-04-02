<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\MessageService;
use KeineWaste\Services\UserService;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class MessagesController
{
    use BaseTrait;
    use LoggerAwareTrait;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var MessageService
     */
    protected $messageService;

    function __construct(MessageService $messageService, UserService $userService)
    {
        $this->messageService = $messageService;
        $this->userService    = $userService;
    }

    /**
     * Message Send action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendAction(Request $request)
    {
        $from = $to = $this->userService->getUsers()[0];


        $message = "test";

        $sentMessage = $this->messageService->sendMessage(
            $from,
            $to,
            $message
        );

        return $this
            ->getResponse()
            ->setData($sentMessage)
            ->setStatusCode(201);
    }
}