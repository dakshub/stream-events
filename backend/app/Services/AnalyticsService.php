<?php

namespace App\Services;

use App\Repositories\DonationRepository;
use App\Repositories\FollowerRepository;
use App\Repositories\MerchSaleRepository;
use App\Repositories\SubscriberRepository;

class AnalyticsService
{
    public const DAYS = 30;
    public const TOP_ITEMS_BY_SALES_LIMIT = 3;

    protected $followerRepository;
    protected $subscriberRepository;
    protected $donationRepository;
    protected $merchSaleRepository;

    public function __construct(
        FollowerRepository $followerRepository,
        SubscriberRepository $subscriberRepository,
        DonationRepository $donationRepository,
        MerchSaleRepository $merchSaleRepository
    ) {
        $this->followerRepository = $followerRepository;
        $this->subscriberRepository = $subscriberRepository;
        $this->donationRepository = $donationRepository;
        $this->merchSaleRepository = $merchSaleRepository;
    }

    public function getTotalRevenue(int $userId): float
    {
        $totalRevenue = 0.0;

        $totalRevenue += $this->donationRepository->getRevenueMadeFromDonations($userId, self::DAYS);
        $totalRevenue += $this->subscriberRepository->getRevenueMadeFromSubscriptions($userId, self::DAYS);
        $totalRevenue += $this->merchSaleRepository->getRevenueMadeFromMerchSales($userId, self::DAYS);

        return $totalRevenue;
    }

    public function getTotalFollowersGained(int $userId): int
    {
        return $this->followerRepository->getTotalFollowersGained($userId, self::DAYS);
    }

    public function getTopItemsBySales(int $userId): array
    {
        return $this->merchSaleRepository->getTopItemsBySales($userId, self::DAYS, self::TOP_ITEMS_BY_SALES_LIMIT);
    }
}
