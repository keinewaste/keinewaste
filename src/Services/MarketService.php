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
        // comparing categories
        $offers = $this->offersRep->findAll();
        /** @var Offer $offer */
        $offer = $offers[0];
        $categories = $offer->getCategories();
        $categoriesIds = [];
        foreach ($categories as $cat) {
            $categoriesIds[] = $cat->getId();
        }

        $categoriesIds = [1,3, 2];
        $consumerCategories = [1,2,3];

        sort($categoriesIds);
        sort($consumerCategories);

        $match = $categoriesIds == array_values(array_intersect($consumerCategories, $categoriesIds));

        // comparing delivery type
        $donorDeliveryType = 'pickup';
        $consumerDeliveryType = 'delivery';

        $match = $consumerDeliveryType == 'pickup' || $consumerDeliveryType != $donorDeliveryType;

        // comparing time
        $dateOffer = new \DateTime('now');

        $dateConsumeFrom = new \DateTime('2016-04-03 02:00:00');
        $dateConsumeTo = new \DateTime('2016-04-03 05:00:00');

        $r = $dateOffer > $dateConsumeFrom && $dateOffer < $dateConsumeTo;

        // comparing distance
        $r = $this->geo->getInRadius(
            "Karl-Marx-Straße 100, Berlin",
            [
                5 => "Greifswalder Straße 212, Berlin",
                7 => "Charlottenstraße 2, 10969, Berlin",
            ],
            6000
        );
        $r = array_column($r, 'id');
        var_export($r);die;

//        $matchedIds

    }
}
