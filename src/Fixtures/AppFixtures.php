<?php

namespace App\Fixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\Clock\now;


class AppFixtures
{
    public function load(ObjectManager $manager): void
    {
       // for ($i = 0; $i < 10; $i++) {
            $question = new Question();
            $question->setId(1);
            $question->setEntitled('2 x 7');
            $question->setResponse('14');
            $question->setDateStart(new \DateTimeImmutable('today -50 minutes'));
            $question->setDateEnd(new \DateTimeImmutable('today -40 minutes'));
       // }

        $manager->persist($question);
        $manager->flush();

    }
}