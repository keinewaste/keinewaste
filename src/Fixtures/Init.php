<?php

namespace KeineWaste\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use KeineWaste\Dto\Offer;
use KeineWaste\Dto\User;

class Init implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User(
            new \DateTime('2016-04-02 12:58:29'),
            'Mark Sugarmountain',
            []
        );

        $manager->persist($user);

        // @todo:created_at should be generated
        $offer = new Offer(
            new \DateTime("now"),
            'pickup',
            'blabla',
            5,
            'https://espngrantland.files.wordpress.com/2015/07/minions_bananas.jpg',
            new \DateTime("now"),
            'new',
            'my bananas',
            $user
        );

        $manager->persist($offer);

        $manager->flush();
    }
}