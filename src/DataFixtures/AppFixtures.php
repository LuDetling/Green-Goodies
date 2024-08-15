<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $product1 = new Product();
        $product1->setPicture("images/product1.jpeg")
            ->setName("Savon Bio")
            ->setShortDescription("Thé, Orange & Girofle")
            ->setFullDescription("Full description")
            ->setPrice(18.90);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setPicture("images/product2.jpeg")
            ->setName("Nécessaire, déodorant Bio")
            ->setShortDescription("50ml déodorant à l’eucalyptus")
            ->setFullDescription("Full description")
            ->setPrice(8.50);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setPicture("images/product3.jpeg")
            ->setName("Kit couvert en bois")
            ->setShortDescription("Revêtement Bio en olivier & sac de transport")
            ->setFullDescription("Full description")
            ->setPrice(12.30);
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setPicture("images/product4.jpeg")
            ->setName("Brosse à dent")
            ->setShortDescription("Bois de hêtre rouge issu de forêts gérées durablement")
            ->setFullDescription("Full description")
            ->setPrice(5.40);
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setPicture("images/product5.jpeg")
            ->setName("Bougie Lavande & Patchouli")
            ->setShortDescription("Cire naturelle")
            ->setFullDescription("Full description")
            ->setPrice(32);
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setPicture("images/product6.jpeg")
            ->setName("Disques Démaquillants x3")
            ->setShortDescription("Solution efficace pour vous démaquiller en douceur ")
            ->setFullDescription("Full description")
            ->setPrice(19.90);
        $manager->persist($product6);

        $product7 = new Product();
        $product7->setPicture("images/product7.jpeg")
            ->setName("Gourde en bois")
            ->setShortDescription("50cl, bois d’olivier")
            ->setFullDescription("Full description")
            ->setPrice(16.90);
        $manager->persist($product7);

        $product8 = new Product();
        $product8->setPicture("images/product8.jpeg")
            ->setName("Shot Tropical")
            ->setShortDescription("Fruits frais, pressés à froid")
            ->setFullDescription("Full description")
            ->setPrice(4.50);
        $manager->persist($product8);

        $product9 = new Product();
        $product9->setPicture("images/product9.jpeg")
            ->setName("Kit d'hygiène recyclable ")
            ->setShortDescription("Pour une salle de bain éco-friendly")
            ->setFullDescription("Full description")
            ->setPrice(24.99);
        $manager->persist($product9);

        $user1 = new User();
        $user1->setActiveApi(0)
            ->setEmail("marie.heuman@gmail.com")
            ->setFirstname("Marie")
            ->setLastname("Heuman")
            ->setPassword($this->passwordHasher->hashPassword($user1, 'admin'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setActiveApi(1)
            ->setEmail("lucas.detling@gmail.com")
            ->setFirstname("Lucas")
            ->setLastname("Detling")
            ->setPassword($this->passwordHasher->hashPassword($user2, 'admin'))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user2);

        $manager->flush();
    }
}
