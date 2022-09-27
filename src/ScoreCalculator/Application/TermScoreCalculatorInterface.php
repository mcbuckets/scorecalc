<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Application;

use App\ScoreCalculator\Domain\VO\TermScoreResultValue;

interface TermScoreCalculatorInterface
{
    public function calculateScoreForTerm(string $term): TermScoreResultValue;
}
