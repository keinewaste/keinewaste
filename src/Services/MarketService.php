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
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
}
