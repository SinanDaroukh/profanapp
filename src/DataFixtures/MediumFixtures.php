<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Medium;

class MediumFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(100,'main_medium', function ($i) {
            $medium = new Medium();
            $medium->setNom($this->faker->words(3, true));
            $medium->setDescription($this->faker->sentence(3, true));
            $medium->setQuantity($this->faker->numberBetween(0,99));
            $medium->setCodebarre($this->faker->ean13);
            $medium->setType($this->faker->numberBetween(1,4));
            $medium->setLocalisation($this->faker->numberBetween(1,4));

            return $medium;

        });

        $manager->flush();
    }
}
