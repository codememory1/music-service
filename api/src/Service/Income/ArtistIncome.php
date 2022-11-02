<?php

namespace App\Service\Income;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\PlatformSettingEnum;
use App\Repository\MultimediaAuditionRepository;
use App\Repository\TransactionRepository;
use App\Service\PlatformSettingService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class ArtistIncome
{
    public function __construct(
        private readonly PlatformSettingService $platformSettingService,
        private readonly MultimediaAuditionRepository $multimediaAuditionRepository,
        private readonly TransactionRepository $transactionRepository
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getArtistApproximatePercentIncome(User $artist): float
    {
        return $this->getApproximatePercentIncome($artist->getTotalNumberAuditions());
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMultimediaApproximatePercentIncome(Multimedia $multimedia): float
    {
        return $this->getApproximatePercentIncome($multimedia->getAuditions()->count());
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getIncomeAmountFromPercent(float $percentIncome): float
    {
        $platformTurnover = $this->transactionRepository->getMonthlyTurnover();
        $monthlyExpenses = $this->platformSettingService->get(PlatformSettingEnum::MONTHLY_EXPENSES);
        $artistPlatformPercent = (float) $this->platformSettingService->get(PlatformSettingEnum::PERCENT_ARTIST_INCOME_FROM_TURNOVER);
        $artistPlatformAmount = (($platformTurnover - $monthlyExpenses) * $artistPlatformPercent) / 100;

        if (0.0 === $percentIncome) {
            return 0.0;
        }

        $amountIncome = ($artistPlatformAmount * $percentIncome) / 100;

        return 0 > $amountIncome ? 0.0 : $amountIncome;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    private function getApproximatePercentIncome(int $numberAuditions): float
    {
        $totalAuditionsByAllArtists = $this->multimediaAuditionRepository->countForCurrentMonth();

        if (0 === $numberAuditions) {
            return 0.0;
        }

        return ($numberAuditions * 100) / $totalAuditionsByAllArtists;
    }
}