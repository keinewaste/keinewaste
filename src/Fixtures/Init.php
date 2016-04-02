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
        $user = new User(
            'Greifswalder Str 212',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a elit eget augue rhoncus dapibus vitae sed massa. Nunc eget convallis leo. Sed vel varius odio. Duis vitae sem ligula. Nullam fermentum dapibus lacus, a efficitur turpis aliquet et. In congue nisi ex, ut mollis risus imperdiet dapibus. Ut scelerisque quis arcu non bibendum. Nullam ultricies enim eget lacus suscipit, ut mollis felis viverra. Mauris sed lorem maximus, porttitor dui ac, tempus justo. Phasellus vulputate ipsum a tellus porta accumsan. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse nec ex consectetur, malesuada ipsum at, pharetra diam. Proin euismod augue ut massa finibus, non congue odio gravida. Nullam porta leo ligula, non scelerisque nisi laoreet sed. Ut sit amet sapien et tellus sollicitudin sodales a at ante.',
            'FeedingFeeding',
            'no@email.com',
            'Mark Sugarmountain',
            'food_bank',
            'http://tasteforlife.com/sites/default/files/styles/desktop/public/field/image/HungryQuiz.jpg?itok=C-4TGxzh',
            [],
            new \DateTime('2016-04-02 12:58:29')
        );

        $manager->persist($user);

        $categoriesRepository = $manager->getRepository('KeineWaste\Dto\Category');

        // @todo:created_at should be generated
        $offer = new Offer(
            $user,
            'pickup',
            'blabla',
            5,
            [],
            new \DateTime("now"),
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
