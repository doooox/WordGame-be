<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class WordsController extends AbstractController
{
    #[Route('/api/words', name: 'app_words')]
    public function index(PersistenceManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $word = null;

        $requestData = json_decode($request->getContent(), true);
        $word = $requestData['word'] ?? null;

        if (!$word) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Word parameter is missing',
            ], Response::HTTP_BAD_REQUEST);
        }

        $wordExists = $doctrine->getRepository(Word::class)->findOneBy(['word' => $word]);
        if (!$wordExists) {
            $error = "$word is not in the English dictionary";
            return new JsonResponse(['error' => $error]);
        }

        $score = $wordExists->getScore();

        return new JsonResponse([
            'success' => true,
            'message' => sprintf('The word "%s" scored %d points.', $word, $score),
            'score' => $score,
            'error' => null
        ]);
    }
}
