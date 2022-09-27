<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain\Model;

use Assert\Assertion;

use App\ScoreCalculator\Domain\VO\TermScoreResultValue;

final class TermScore
{
    public function __construct(
        private string $term,
        private float $score,
    ) {
        Assertion::notEmpty($term, '$term should not be empty');
        Assertion::greaterOrEqualThan($score, 0, '$score should be >= 0');
        Assertion::lessOrEqualThan($score, 10, '$score should be <= 10');
    }

    public function term(): string
    {
        return $this->term;
    }

    public function score(): float
    {
        return $this->score;
    }

    #[ArrayShape(['term' => "string", 'score' => "float"])]
    public function asArray(): array
    {
        return [
            'term' => $this->term(),
            'score' => $this->score(),
        ];
    }

    public static function fromTermScoreResultValue(TermScoreResultValue $termScoreResultValue): self
    {
        return new self($termScoreResultValue->term(), $termScoreResultValue->score());
    }
}
