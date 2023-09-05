<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function totalRevenue(Request $request): JsonResponse
    {
        $user = $request->user();

        $totalRevenue = $this->analyticsService->getTotalRevenue($user);

        return response()->json([
            'total_revenue' => $totalRevenue
        ]);
    }

    public function totalFollowersGained(Request $request): JsonResponse
    {
        $user = $request->user();

        $totalFollowersGained = $this->analyticsService->getTotalFollowersGained($user);

        return response()->json([
            'total_followers_gained' => $totalFollowersGained
        ]);
    }

    public function topItemsBySales(Request $request): JsonResponse
    {
        $user = $request->user();

        $topItemsBySales = $this->analyticsService->getTopItemsBySales($user);

        return response()->json([
            'top_items_by_sales' => $topItemsBySales
        ]);
    }
}
