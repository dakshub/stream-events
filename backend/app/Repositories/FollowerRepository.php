<?php

namespace App\Repositories;

use App\Models\Follower;

class FollowerRepository
{

    public function getTotalFollowersGained(int $userId, int $days): int
    {
        return Follower::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays($days))
            ->count();
    }
}
