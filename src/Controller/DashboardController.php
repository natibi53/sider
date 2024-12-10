<?php

namespace App\Controller;

use App\Service\RedisSiderGameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $redisSiderGameService;

    public function __construct(RedisSiderGameService $redisSiderGameService)
    {
        $this->redisSiderGameService = $redisSiderGameService;
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $leaderboard = $this->redisSiderGameService->getLeaderboard();

        $players = [];
        foreach ($leaderboard as $playerId => $score) {
            $playerData = $this->redisSiderGameService->getPlayerData($playerId);
            if ($playerData) {
                $players[] = [
                    'name' => $playerData['name'],
                    'score' => $score,
                ];
            }
        }
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'players' => $players,
        ]);
    }
}
