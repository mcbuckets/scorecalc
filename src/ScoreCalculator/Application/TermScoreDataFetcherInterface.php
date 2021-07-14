<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Application;

use App\ScoreCalculator\Domain\TermScoreValue;

interface TermScoreDataFetcherInterface
{
    public function getTermValuationData(string $term): TermScoreValue;
}
