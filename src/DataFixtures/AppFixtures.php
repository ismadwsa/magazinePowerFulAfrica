<?php

namespace App\DataFixtures;

use App\Entity\NewsLetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {  
        $client = new NewsLetter();
        $client->setAdresseMail('isma@pop.fr');
       
        
        $manager->persist($client);

        $manager->flush();
    }
}
