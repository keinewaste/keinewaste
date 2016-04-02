<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\Spoonacular;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class AutocompleteController
{
    use BaseTrait;

    /** @var Spoonacular $em */
    protected $api;

    function __construct(Spoonacular $api)
    {
        $this->api = $api;
    }

    /**
     * User action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function suggestAction(Request $request)
    {
        $result = $this->api->autocomplete($request->get('query'));

        return $this
            ->getResponse()
            ->setData($result);
    }
}