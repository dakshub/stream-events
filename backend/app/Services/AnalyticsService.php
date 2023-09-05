<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\DonationRepository;
use App\Repositories\FollowerRepository;
use App\Repositories\MerchSaleRepository;
use App\Repositories\SubscriberRepository;

class AnalyticsService
{
    public const DAYS = 30;
    public const TOP_SELLING_ITEMS_LIMIT = 3;

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

    public function getTotalRevenue(User $user): float
    {
        $totalRevenue = 0.0;

        $totalRevenue += $this->donationRepository->getRevenueMadeFromDonations($user, self::DAYS);
        $totalRevenue += $this->subscriberRepository->getRevenueMadeFromSubscriptions($user, self::DAYS);
        $totalRevenue += $this->merchSaleRepository->getRevenueMadeFromMerchSales($user, self::DAYS);

        return $totalRevenue;
    }

    public function getTotalFollowersGained(User $user): int
    {
        return $this->followerRepository->getTotalFollowersGained($user, self::DAYS);
    }

    public function getTopSellingItems(User $user): array
    {
        return $this->merchSaleRepository->getTopSellingItems($user, self::DAYS, self::TOP_SELLING_ITEMS_LIMIT);
    }
}
