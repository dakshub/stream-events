<?php

namespace App\Repositories;

use App\Models\Donation;

class DonationRepository
{

    public function getRevenueMadeFromDonations(int $userId, int $days): float
    {
        return Donation::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays($days))
            ->sum('amount') ?? 0.0;
    }
}
