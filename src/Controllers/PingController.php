<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class PingController
{
    use BaseTrait;

    /**
     * Ping action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function pingAction(Request $request)
    {
        return $this
            ->getResponse()
            ->setData(['result' => 'PONG']);
    }
}