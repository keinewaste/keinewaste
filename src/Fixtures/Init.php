<?php

namespace KeineWaste\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use KeineWaste\Dto\Offer;
use KeineWaste\Dto\Product;
use KeineWaste\Dto\User;

class Init extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {


        $user = new User(1, 'no@email.com', 'Mark Sugarmountain');
        $user->setAddress('Greifswalder Str 212');
        $user->setCompanyName('FeedingFeeding');
        $user->setType('foodbank');

        $user->setToken('CAAYBQjWI6owBAJjuUjikvtFoAjPkNcpm5gFzZCu5d6SXg1NwsHQdwc7SaA7TZBK0ob3kOAvogAOhtOMIwhR0KNqzZAXuDb5iTaWmWRQ2B36FXZBJysy9RdBZBqF82Ud04NvxZAMaz5tyKEg9SXB8LZB6ZCRuZA7aMx6WryNw5IJeMRwem3yBF7Icsz4hkj21r0uPnYLJgTIiEuTEo3yNOkn5n');

        $manager->persist($user);

        $categoriesRepository = $manager->getRepository('KeineWaste\Dto\Category');

        // @todo:created_at should be generated
        $offer = new Offer(
            new \DateTime("now"),
            'pickup',
            'blabla',
            5,
            [],
            new \DateTime("now"),
            'new',
            $user,
            [$categoriesRepository->find(1), $categoriesRepository->find(2)]
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

    public function getOrder()
    {
        return 10;
    }
}
