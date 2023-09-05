<?php

namespace App\Repositories;

use App\Models\MerchSale;
use App\Models\User;

class MerchSaleRepository
{
    public function getRevenueMadeFromMerchSales(User $user, int $days): float
    {
        return MerchSale::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays($days))
            ->sum('total');
    }

    public function getTopSellingItems(User $user, int $days, int $limit): array
    {
        return MerchSale::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays($days))
            ->selectRaw('item, SUM(total) AS total_sale')
            ->groupBy('item')
            ->orderByDesc('total_sale')
            ->limit($limit)
            ->get()
            ->pluck('item')
            ->toArray();
    }
}
