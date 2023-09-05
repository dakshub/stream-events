<?php

namespace App\Repositories;

use App\Models\MerchSale;

class MerchSaleRepository
{
    public function getRevenueMadeFromMerchSales(int $userId, int $days): float
    {
        return MerchSale::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays($days))
            ->sum('total') ?? 0.0;
    }

    public function getTopItemsBySales(int $userId, int $days, int $limit): array
    {
        return MerchSale::where('user_id', $userId)
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
