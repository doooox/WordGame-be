<?php

namespace App\Tests;


use App\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        // Create a mock word in the database
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $word = new Word();
        $word->setWord('level');
        $entityManager->persist($word);
        $entityManager->flush();

        // Make a request to the controller
        $client->request('POST', '/api/words', [], [], [], json_encode(['word' => 'level']));

        // Check the response
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
            "success": true,
            "message": "The word \"level\" scored 6 points.",
            "score": 6,
            "error": null
        }', $client->getResponse()->getContent());
    }
}
