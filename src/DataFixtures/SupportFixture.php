<?php

namespace App\DataFixtures;

use App\Entity\Support;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SupportFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->createMany(100,'main_support', function ($i) {
            $support = new Support();
            $support->setName($this->faker->words(3, true));
            $support->setDescription($this->faker->sentence(3, true));
            $support->setGrammage($this->faker->numberBetween(0,10));
            $support->setQuantity($this->faker->numberBetween(0,99));
            $support->setBarcode($this->faker->ean13);
            $support->setType($this->faker->numberBetween(0,4));

            return $support;

        });

        $manager->flush();
    }
}
