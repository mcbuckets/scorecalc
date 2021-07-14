<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain;

final class TermScoreValue
{

    private function __construct(
        private int $positiveScore,
        private int $negativeScore,
        private int $sum,
    ) {}

    public static function from(int $positiveScore, int $negativeScore): self
    {
        $sum = $positiveScore + $negativeScore;

        return new self($positiveScore, $negativeScore, $sum);
    }

    public function getPositiveScore(): int
    {
        return $this->positiveScore;
    }

    public function getNegativeScore(): int
    {
        return $this->negativeScore;
    }

    public function getSum(): int
    {
        return $this->sum;
    }
}
