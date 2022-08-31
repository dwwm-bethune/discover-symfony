<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('iPhone');
        $product->setDescription('Un smartphone');
        $product->setPrice(1000 * 100);
        $manager->persist($product);

        $product = new Product();
        $product->setName('Macbook');
        $product->setDescription('Un ordinateur');
        $product->setPrice(2000 * 100);
        $manager->persist($product);

        $manager->flush();
    }
}
