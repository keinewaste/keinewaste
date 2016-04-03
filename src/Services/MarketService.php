<?php
namespace KeineWaste\Services;

use Doctrine\ORM\EntityManagerInterface;
use KeineWaste\Dto\Offer;
use KeineWaste\Dto\Product;
use KeineWaste\Dto\User;
use Psr\Log\LoggerAwareTrait;

class MarketService
{
    use LoggerAwareTrait;

    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    /**
     * @var Geolocation $geo
     */
    protected $geo;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $usersRep
     */
    protected $usersRep;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $offersRep
     */
    protected $offersRep;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $productsRep
     */
    protected $productsRep;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $categoriesRep
     */
    protected $categoriesRep;

    /**
     * MarketService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, Geolocation $geo)
    {
        $this->em = $em;
        $this->geo = $geo;
        $this->usersRep = $em->getRepository('KeineWaste\Dto\User');
        $this->offersRep = $em->getRepository('KeineWaste\Dto\Offer');
        $this->productsRep = $em->getRepository('KeineWaste\Dto\Product');
        $this->categoriesRep = $em->getRepository('KeineWaste\Dto\Category');
    }

    /**
     * @param User      $user
     * @param string    $deliveryType
     * @param string    $description
     * @param string    $distance
     * @param Product[] $products
     * @param \DateTime $meetingTime
     * @param integer[] $categoryIds
     *
     * @return \KeineWaste\Dto\Offer
     */
    public function createOffer($user, $deliveryType, $description, $distance, $products, $meetingTime, $categoryIds)
    {
        $categories = [];
        foreach ($categoryIds as $categoryId) {
            $categories[] = $this->categoriesRep->find($categoryId);
        }

        $offer = new Offer($user, $deliveryType, $description, $distance, [], $meetingTime, $categories);

        $this->em->persist($offer);
        foreach ($products as $productData) {
            $product = new Product(
                $productData['title'],
                $productData['imageUrl'],
                $productData['quantity'],
                $offer
            );
            $product->setOffer($offer);
            $this->em->persist($product);
        }

        $this->em->flush();
        $this->em->refresh($offer);

        return $offer;
    }

    public function getOfferById($id)
    {
        return $this->offersRep->find($id);
    }

    public function getOffers()
    {
        return $this->offersRep->findAll();
    }

    public function getOffersByUserId($userId)
    {
        return $this->offersRep->findBy(['user' => $userId]);
    }

    public function getMatches(Offer $offer)
    {
        $candidates = $this->usersRep->findBy(['type' => User::USER_TYPE_RECEIVER]);

        if (!count($candidates)) return [];



        // comparing categories
        $categories = $offer->getCategories();
        $categoriesIds = [];
        foreach ($categories as $cat) {
            $categoriesIds[] = $cat->getId();
        }
        sort($categoriesIds);

        $candidates = array_filter($candidates, function (User $user) use ($categoriesIds) {
            $consumerCategories = [];
            foreach ($user->getCategories() as $cat) {
                $consumerCategories[] = $cat->getId();
            }
            sort($consumerCategories);

            return $categoriesIds == array_values(array_intersect($consumerCategories, $categoriesIds));
        });

        if (!count($candidates)) return [];



        // comparing delivery type
        $donorDeliveryType = $offer->getDeliveryType();

        $candidates = array_filter($candidates, function (User $user) use ($donorDeliveryType) {
            return $user->getDeliveryType() == 'pickup' || $user->getDeliveryType() != $donorDeliveryType;
        });

        if (!count($candidates)) return [];



        // comparing time
        /** @var \DateTime $donorMeetingTime */
        $donorMeetingTime = $offer->getMeetingTime();

        $candidates = array_filter($candidates, function (User $user) use ($donorMeetingTime) {
            /** @var \DateTime $dateConsumeFrom */
            $dateConsumeFrom = $user->getMeetingTimeFrom();
            $dateConsumeFrom->setDate(
                $donorMeetingTime->format('Y'),
                $donorMeetingTime->format('m'),
                $donorMeetingTime->format('d')
            );

            /** @var \DateTime $dateConsumeTo */
            $dateConsumeTo = $user->getMeetingTimeTo();
            $dateConsumeTo->setDate(
                $donorMeetingTime->format('Y'),
                $donorMeetingTime->format('m'),
                $donorMeetingTime->format('d')
            );

            // @todo: but is it today?
            return $donorMeetingTime > $dateConsumeFrom && $donorMeetingTime < $dateConsumeTo;
        });

        if (!count($candidates)) return [];


         
        // comparing distance
        $destinations = [];
        foreach ($candidates as $user) {
            $destinations[$user->getId()] = $user->getAddress();
        }

        //@todo: we don't count consumer distance there

        $inRadius = $this->geo->getInRadius(
            $offer->getUser()->getAddress(),
            $destinations,
            $offer->getDistance()
        );
        $inRadiusIds = array_column($inRadius, 'id');
        $candidates = array_filter($candidates, function (User $user) use ($inRadiusIds) {
            return in_array($user->getId(), $inRadiusIds);
        });

        if (!count($candidates)) return [];

        return $candidates[0];
    }
}
