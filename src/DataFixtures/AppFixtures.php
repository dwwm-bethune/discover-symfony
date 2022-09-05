<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $types = ['Smartphone', 'Tablette', 'PC portable', 'PC bureau', 'Ecran'];

        foreach ($types as $key => $type) {
            $category = new Category();
            $category->setName($type);
            $manager->persist($category);
            $this->addReference('category-'.($key + 1), $category);
        }

        // Créer une entité Tag avec un name...
        // Créer une relation (tags) ManyToMany entre Product et Tag
        // Créer quelques tags dans les fixtures (gaming, perso, pro, bureau, jeu)
        // Associer les tags à des produits (fixtures)
        // Afficher la liste des tags sur la liste des produits
        // Ajouter un champ dans le formulaire (checkboxes)

        for ($i = 0; $i <= 20; $i++) {
            $product = new Product();
            $product->setName($faker->sentence());
            $product->setDescription($faker->text());
            $product->setPrice($faker->numberBetween(100, 2000) * 100);
            $product->setCategory($this->getReference('category-'.rand(1, 5)));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
