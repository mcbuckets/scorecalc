<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Application;

use App\ScoreCalculator\Domain\VO\TermScoreResultValue;

final class TermScoreCalculator implements TermScoreCalculatorInterface
{
    public function __construct(
        private TermScoreDataFetcherInterface $termScoreDataFetcher
    ) {
    }

    public function calculateScoreForTerm(string $term): TermScoreResultValue
    {
        $valuationData = $this->termScoreDataFetcher->getTermValuationData($term);

        if (($sum = $valuationData->sum()) > 0) {
            return TermScoreResultValue::from(
                $term,
                round($valuationData->positiveScore() / $sum, 2)
            );
        }

        return TermScoreResultValue::from($term, 0);
    }
}
