<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $product1 = new Product();
        $product1->setImage("images/product1.jpeg")
            ->setTitle("Savon Bio")
            ->setDescription("Thé, Orange & Girofle")
            ->setPrice(18.90);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setImage("images/product2.jpeg")
            ->setTitle("Nécessaire, déodorant Bio")
            ->setDescription("50ml déodorant à l’eucalyptus")
            ->setPrice(8.50);
        $manager->persist($product2);
        
        $product3 = new Product();
        $product3->setImage("images/product3.jpeg")
            ->setTitle("Kit couvert en bois")
            ->setDescription("Revêtement Bio en olivier & sac de transport")
            ->setPrice(12.30);
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setImage("images/product4.jpeg")
            ->setTitle("Brosse à dent")
            ->setDescription("Bois de hêtre rouge issu de forêts gérées durablement")
            ->setPrice(5.40);
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setImage("images/product5.jpeg")
            ->setTitle("Bougie Lavande & Patchouli")
            ->setDescription("Cire naturelle")
            ->setPrice(32);
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setImage("images/product6.jpeg")
            ->setTitle("Disques Démaquillants x3")
            ->setDescription("Solution efficace pour vous démaquiller en douceur ")
            ->setPrice(19.90);
        $manager->persist($product6);

        $product7 = new Product();
        $product7->setImage("images/product7.jpeg")
            ->setTitle("Gourde en bois")
            ->setDescription("50cl, bois d’olivier")
            ->setPrice(16.90);
        $manager->persist($product7);

        $product8 = new Product();
        $product8->setImage("images/product8.jpeg")
            ->setTitle("Shot Tropical")
            ->setDescription("Fruits frais, pressés à froid")
            ->setPrice(4.50);
        $manager->persist($product8);

        $product9 = new Product();
        $product9->setImage("images/product9.jpeg")
            ->setTitle("Kit d'hygiène recyclable ")
            ->setDescription("Pour une salle de bain éco-friendly")
            ->setPrice(24.99);
        $manager->persist($product9);

        $manager->flush();
    }
}
