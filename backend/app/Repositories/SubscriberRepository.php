<?php

namespace App\Repositories;

use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class SubscriberRepository
{
    public function getRevenueMadeFromSubscriptions(int $userId, int $days): float
    {
        return Subscriber::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('
                    SUM(CASE WHEN subscription_tier = 1 THEN 5
                    WHEN subscription_tier = 2 THEN 10
                    WHEN subscription_tier = 3 THEN 15
                    ELSE 0 END) AS subscription_revenue
            '))
            ->value('subscription_revenue') ?? 0.0;
    }
}
