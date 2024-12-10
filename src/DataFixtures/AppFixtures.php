<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         for ($i = 10; $i > 0; $i--) {
            $question = new Question();
            $question->setEntitled("{$i} x 17");
            $question->setResponse($i * 17);
            $timestart= $i*10;
            $timeend= $timestart -10;
            $question->setDateStart(new \DateTimeImmutable("now -{$timestart} minutes"));
            $question->setDateEnd(new \DateTimeImmutable("now -{$timeend} minutes"));
             $manager->persist($question);
         }


        $manager->flush();
    }
}
