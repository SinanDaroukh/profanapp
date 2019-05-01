<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Medium;

class MediumFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<10; $i++){
            $medium = new Medium();

            $medium->setcodebarre($i)
                ->setnom("Nom de l'objet n°$i")
                ->setdescription("Une petite description de l'objet $i")
                ->settype("Le type de l'objet")
                ->setlocalisation("La localisation de l'objet")
            ;

            $manager->persist($medium);
        }

        $manager->flush();
    }
}
