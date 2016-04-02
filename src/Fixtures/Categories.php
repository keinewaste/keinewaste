<?php

namespace KeineWaste\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use KeineWaste\Dto\Category;

class Categories extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat1 = new Category(1, 'Bread');
        $manager->persist($cat1);

        $cat2 = new Category(2, 'Dairy products/Eggs');
        $manager->persist($cat2);

        $cat3 = new Category(3, 'Vegetables/Fruits');
        $manager->persist($cat3);

        $cat4 = new Category(4, 'Meat/Fish/Seafood');
        $manager->persist($cat4);

        $cat5 = new Category(5, 'Prepared food');
        $manager->persist($cat5);

        $cat5 = new Category(6, 'Prepared food (Veggie)');
        $manager->persist($cat5);

        $cat5 = new Category(7, 'Prepared food (Vegan)');
        $manager->persist($cat5);

        $cat5 = new Category(8, 'Prepared food (Halal)');
        $manager->persist($cat5);

        $cat5 = new Category(9, 'Prepared food (Kosher)');
        $manager->persist($cat5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}