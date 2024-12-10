<?php

namespace App\Service;

use Predis\Client;

class RedisSiderGameService
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Client(); // Utilise l'adresse par défaut : 127.0.0.1:6379
    }

    public function createPlayer($id, $name, $email, $dateInscription, $avatar)
    {
        $this->redis->hmset("player:$id", [
            'name' => $name,
            'email' => $email,
            'date_inscription' => $dateInscription,
            'avatar' => $avatar,
        ]);
        $this->redis->zadd('leaderboard:sider', [$id => 0]);
    }

    public function incrementScoreLeaderBoard($id, $scoreToIncrement)
    {
        $this->redis->zincrby('leaderboard:sider', $scoreToIncrement, $id);
        $this->redis->zincrby('leaderboard:sider:tenmin', $scoreToIncrement, $id);
        $this->redis->expireat('leaderboard:sider:tenmin', strtotime (date('Y-m-d H'.floor(date("i") / 10) + 1)));

        $this->redis->lpush('score_history:'.$id, $scoreToIncrement);
    }


    public function getLeaderboard()
    {
        return $this->redis->zrevrange('leaderboard:sider', 0, 10, ['WITHSCORES' => true]);
    }

    public function getLeaderboardTenMin()
    {
        return $this->redis->zrevrange('leaderboard:sider:tenmin', 0, 10, ['WITHSCORES' => true]);
    }

    public function getPlayerScores($id)
    {
        return $this->redis->lrange('score_history:'.$id, 0, 10);
    }
    public function getPlayerData($id)
    {
        return $this->redis->hgetall("player:$id");
    }

}