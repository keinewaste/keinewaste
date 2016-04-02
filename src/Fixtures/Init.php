<?php

namespace KeineWaste\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use KeineWaste\Dto\Offer;
use KeineWaste\Dto\Product;
use KeineWaste\Dto\User;

class Init implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User(
            new \DateTime('2016-04-02 12:58:29'),
            'Mark Sugarmountain',
            'info@sugar.com',
            []
        );

        $manager->persist($user);

        // @todo:created_at should be generated
        $offer = new Offer(
            new \DateTime("now"),
            'pickup',
            'blabla',
            5,
            [],
            new \DateTime("now"),
            'new',
            $user
        );

        $manager->persist($offer);

        $product1 = new Product(
            'my bananas',
            'https://espngrantland.files.wordpress.com/2015/07/minions_bananas.jpg',
            '2pcs',
            $offer
        );

        $manager->persist($product1);

        $product2 = new Product(
            'Potatas',
            'http://www.potatoes.com/files/5713/4202/4172/07.jpg',
            '10kg',
            $offer
        );

        $manager->persist($product2);

        $manager->flush();
    }
}