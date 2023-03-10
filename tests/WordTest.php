<?php

namespace App\Tests;

use App\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordTest extends WebTestCase
{
    public function testWordFound(): void
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $word = new Word();
        $word->setWord('levels');
        $entityManager->persist($word);
        $entityManager->flush();

        $client->request('POST', '/api/words', [], [], [], json_encode(['word' => 'levels']));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
            "success": true,
            "message": "The word \"levels\" scored 6 points.",
            "score": 6,
            "error": null
        }', $client->getResponse()->getContent());
    }
    public function testNoWordSent()
    {

        $client = static::createClient();

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $word = new Word();
        $word->setWord('levels');
        $entityManager->persist($word);
        $entityManager->flush();

        $client->request('POST', '/api/words', [], [], [], json_encode(['word' => '']));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
            "success": false,
            "message": "Word parameter is missing"
        }', $client->getResponse()->getContent());
    }
    public function testWordNoEnglish()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $word = new Word();
        $word->setWord('levels');
        $entityManager->persist($word);
        $entityManager->flush();

        $client->request('POST', '/api/words', [], [], [], json_encode(['word' => 'proba']));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
         "error": "proba is not in the English dictionary"
        }', $client->getResponse()->getContent());
    }
}
