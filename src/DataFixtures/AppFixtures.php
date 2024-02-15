<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductPromotion;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* Add Promotions */
        $promotionsOne = new Promotion();
        $promotionsOne->setName('Black Friday half price sale');
        $promotionsOne->setAdjustment(0.5);
        $promotionsOne->setCriteria(['from' => '2022-11-25', 'to' => '2022-11-28']);
        $promotionsOne->setType('date_range_multiplier');
        $manager->persist($promotionsOne);

        $promotionsTwo = new Promotion();
        $promotionsTwo->setName('Voucher OU812');
        $promotionsTwo->setAdjustment(100);
        $promotionsTwo->setCriteria(['code' => 'OU812']);
        $promotionsTwo->setType('fixed_price_voucher');
        $manager->persist($promotionsTwo);

        $promotionsThree = new Promotion();
        $promotionsThree->setName('Buy one get one free');
        $promotionsThree->setAdjustment(0.5);
        $promotionsThree->setCriteria(['minimum_quantity' => 2]);
        $promotionsThree->setType('even_items_multiplier');
        $manager->persist($promotionsThree);

        /* Add Products */
        $product = new Product();
        $product->setPrice(100);
        $manager->persist($product);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsOne);
        $manager->persist($productPromotion);

        $product = new Product();
        $product->setPrice(200);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsTwo);
        $manager->persist($productPromotion);

        $product = new Product();
        $product->setPrice(300);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsThree);
        $manager->persist($productPromotion);

        $product = new Product();
        $product->setPrice(400);
        $manager->persist($product);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsOne);
        $manager->persist($productPromotion);

        $product = new Product();
        $product->setPrice(500);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsTwo);
        $manager->persist($productPromotion);

        $product = new Product();
        $product->setPrice(600);
        $manager->persist($product);

        $productPromotion = new ProductPromotion($product, $promotionsThree);
        $manager->persist($productPromotion);

        $manager->flush();
    }
}
