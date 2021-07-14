<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain;

final class TermScoreResultValue
{
    private function __construct(
        private string $term,
        private float $score,
    )
    {
    }

    public static function from(string $term, float $score): self
    {
        if ($score > 10) $score = 10.00;

        return new self($term, $score);
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}
