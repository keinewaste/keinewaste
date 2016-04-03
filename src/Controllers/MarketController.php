<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\MarketService;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;


class MarketController
{
    use BaseTrait;
    use LoggerAwareTrait;

    /**
     * @var MarketService
     */
    protected $marketService;

    function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

    /**
     * All offers request action
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAllAction(Request $request)
    {
        return $this
            ->getResponse()
            ->setData($this->marketService->getOffers());
    }

    /**
     * Get match
     *
     * @param Request $request Request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return JsonResponse
     */
    public function getOfferMatch(Request $request)
    {
        $offer = $this->marketService->getOfferById($request->get('id'));

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        $match = $this->marketService->getMatches($offer);

        return $this
            ->getResponse()
            ->setData($match);
    }


    /**
     * All offers by specified user action
     *
     * @param Request $request Request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return JsonResponse
     */
    public function getAllByUserAction(Request $request)
    {
        $offers = $this->marketService->getOffersByUserId($request->get('id'));

        if (!$offers) {
            throw new NotFoundHttpException();
        }

        $result = [];
        foreach ($offers as $offer) {
            $result[] = $offer->jsonSerialize();
        }

        return $this
            ->getResponse()
            ->setData($result);
    }

    /**
     * Get one offer by id action
     *
     * @param Request $request Request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return JsonResponse
     */
    public function getOneAction(Request $request)
    {
        $offer = $this->marketService->getOfferById($request->get('id'));

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        return $this
            ->getResponse()
            ->setData($offer);
    }

    /**
     * Create offer action
     *
     * @param Request $request Request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $user = $this->getLoggedUser($request, false);
        if (null === $user) {
            throw new NotFoundHttpException();
        }

        $data = json_decode($request->getContent(), true);

        $offer = $this->marketService->createOffer(
            $user,
            $data['deliveryType'],
            $data['description'],
            $data['distance'],
            $data['products'],
            new \DateTime($data['meetingTime']['date']),
            $data['categories']
        );

        if (!$offer) {
            throw new ServiceUnavailableHttpException();
        }

        return $this
            ->getResponse()
            ->setData($offer);
    }
}