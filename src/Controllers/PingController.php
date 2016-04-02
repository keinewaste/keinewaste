<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class PingController
{
    use BaseTrait;

    /**
     * Return latest git commit
     */
    public function getVersion()
    {
        chdir(realpath(__DIR__ . '/../../'));
        exec("git rev-parse HEAD", $current);
        return $current;
    }

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
            ->setData(['result' => $this->getVersion()]);
    }
}