<?php

namespace App\Repositories;

use App\Models\Follower;
use App\Models\User;

class FollowerRepository
{

    public function getTotalFollowersGained(User $user, int $days): int
    {
        return Follower::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays($days))
            ->count();
    }
}
