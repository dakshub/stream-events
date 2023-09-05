<?php

namespace App\Repositories;

use App\Models\Donation;
use App\Models\User;

class DonationRepository
{

    public function getRevenueMadeFromDonations(User $user, int $days): float
    {
        return Donation::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays($days))
            ->sum('amount');
    }
}
