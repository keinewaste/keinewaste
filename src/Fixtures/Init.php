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
        $categoriesRepository = $manager->getRepository('KeineWaste\Dto\Category');


        $user = new User(1, 'no@email.com', 'Mark Sugarmountain');
        $user->setAddress('Greifswalder Strasse 212, Berlin');
        $user->setCompanyName('FeedingFeeding');
        $user->setType(User::USER_TYPE_DONOR);

        $user->setToken('CAAYBQjWI6owBAJjuUjikvtFoAjPkNcpm5gFzZCu5d6SXg1NwsHQdwc7SaA7TZBK0ob3kOAvogAOhtOMIwhR0KNqzZAXuDb5iTaWmWRQ2B36FXZBJysy9RdBZBqF82Ud04NvxZAMaz5tyKEg9SXB8LZB6ZCRuZA7aMx6WryNw5IJeMRwem3yBF7Icsz4hkj21r0uPnYLJgTIiEuTEo3yNOkn5n');

        $manager->persist($user);

        $consumer1 = new User(2, 'no2@email.com', 'Mariem Yamrali');
        $consumer1->setAddress('Karl-Marx-Strasse 100, Berlin');
        $consumer1->setCompanyName('HelpingMouths');
        $consumer1->setType(User::USER_TYPE_RECEIVER);
        $consumer1->setDeliveryType(User::DELIVERY_TYPE_PICKUP);
        $consumer1->setDistance(10000);
        $consumer1->setCategories([
            $categoriesRepository->find(1),
            $categoriesRepository->find(2),
            $categoriesRepository->find(3),
            $categoriesRepository->find(4),
            $categoriesRepository->find(5),
            $categoriesRepository->find(6),
            $categoriesRepository->find(7),
            $categoriesRepository->find(8),
            $categoriesRepository->find(9),
        ]);
        $consumer1->setMeetingTimeFrom(new \DateTime('2016-04-03 03:00:00'));
        $consumer1->setMeetingTimeTo(new \DateTime('2017-04-03 23:40:00'));
        $consumer1->setToken('xxxxx1wBAJjuUjikvtFoAjPkNcpm5gFzZCu5d6SXg1NwsHQdwc7SaA7TZBK0ob3kOAvogAOhtOMIwhR0KNqzZAXuDb5iTaWmWRQ2B36FXZBJysy9RdBZBqF82Ud04NvxZAMaz5tyKEg9SXB8LZB6ZCRuZA7aMx6WryNw5IJeMRwem3yBF7Icsz4hkj21r0uPnYLJgTIiEuTEo3yNOkn5n');
        $consumer1->setImageUrl('http://s.huffpost.com/contributors/robyn-vie-carpenter/headshot.jpg');
        $manager->persist($consumer1);

        $consumer2 = new User(3, 'no3@email.com', 'Wolly Bolly');
        $consumer2->setAddress('Charlottenstrasse 2, 10969, Berlin');
        $consumer2->setCompanyName('CompanyName 2');
        $consumer2->setType(User::USER_TYPE_RECEIVER);
        $consumer2->setDeliveryType(User::DELIVERY_TYPE_DELIVERY);
        $consumer2->setCategories([$categoriesRepository->find(1) , $categoriesRepository->find(3)]);
        $consumer2->setMeetingTimeFrom(new \DateTime('2016-04-03 00:00:00'));
        $consumer2->setMeetingTimeTo(new \DateTime('2016-04-03 23:00:00'));
        $consumer2->setToken('yyyy1wBAJjuUjikvtFoAjPkNcpm5gFzZCu5d6SXg1NwsHQdwc7SaA7TZBK0ob3kOAvogAOhtOMIwhR0KNqzZAXuDb5iTaWmWRQ2B36FXZBJysy9RdBZBqF82Ud04NvxZAMaz5tyKEg9SXB8LZB6ZCRuZA7aMx6WryNw5IJeMRwem3yBF7Icsz4hkj21r0uPnYLJgTIiEuTEo3yNOkn5n');
        $manager->persist($consumer2);

        // @todo:created_at should be generated
        $offer = new Offer(
            $user,
            'pickup',
            'blabla',
            10000,
            [],
            new \DateTime("2016-04-12 15:00:00"),
            [$categoriesRepository->find(1) , $categoriesRepository->find(2)]
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
