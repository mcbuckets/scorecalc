<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain\Model;

use Assert\Assertion;
use JetBrains\PhpStorm\ArrayShape;

use App\ScoreCalculator\Domain\TermScoreResultValue;

final class TermScore
{
    private int $id;

    public function __construct(
        private string $term,
        private float $score,
    ) {
        Assertion::notEmpty($term, '$term should not be empty');
        Assertion::greaterOrEqualThan($score, 0, '$score should be >= 0');
        Assertion::lessOrEqualThan($score, 10, '$score should be <= 10');
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    #[ArrayShape(['term' => "string", 'score' => "float"])]
    public function asArray(): array
    {
        return [
            'term' => $this->getTerm(),
            'score' => $this->getScore(),
        ];
    }

    public static function fromTermScoreResultValue(TermScoreResultValue $termScoreResultValue): self
    {
        return new self($termScoreResultValue->getTerm(), $termScoreResultValue->getScore());
    }
}
