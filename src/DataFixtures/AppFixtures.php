<?php

namespace App\DataFixtures;

use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filePath = "public/words.txt";
        $words = file($filePath);

        foreach ($words as $word) {
            $entity = new Word();
            $removeNewLine = trim($word, "\n");
            $entity->setWord($removeNewLine);
            $manager->persist($entity);
        }
        $manager->flush();
    }
}
