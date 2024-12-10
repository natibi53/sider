<?php

namespace App\Controller;

use App\Form\AnswerQuestionGameType;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(QuestionsRepository $questionsRepository, Request $request): Response
    {
        $question = $questionsRepository->findCurrent()[0];
        $form = $this->createForm(AnswerQuestionGameType::class);
        $form->handleRequest($request);

        

        return $this->render('game/index.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }
}
