<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain\Model;

interface TermScoreRepositoryInterface
{
    public function findOneByTerm(string $term): ?TermScore;
    public function save(TermScore $termScore): void;
}
