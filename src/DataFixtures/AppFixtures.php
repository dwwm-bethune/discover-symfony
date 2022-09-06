<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('matthieu@boxydev.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setIsVerified(true);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('fiorella@boxydev.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $user->setIsVerified(true);
        $manager->persist($user);

        $types = ['Smartphone', 'Tablette', 'PC portable', 'PC bureau', 'Ecran'];
        foreach ($types as $key => $type) {
            $category = new Category();
            $category->setName($type);
            $manager->persist($category);
            $this->addReference('category-'.($key + 1), $category);
        }

        $keywords = ['Gaming', 'Perso', 'Pro', 'Bureau', 'Internet', 'RVB'];
        foreach ($keywords as $key => $keyword) {
            $tag = new Tag();
            $tag->setName($keyword);
            $manager->persist($tag);
            $this->addReference('tag-'.($key + 1), $tag);
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
            // Ajoute entre 1 et 3 tags aléatoires pour chaque produit...
            foreach (range(1, rand(1, 3)) as $ref) {
                $product->addTag($this->getReference('tag-'.rand(1, 6)));
            }
            $manager->persist($product);
        }

        $manager->flush();
    }
}
