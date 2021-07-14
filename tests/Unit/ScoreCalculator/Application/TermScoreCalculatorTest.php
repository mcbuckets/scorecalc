<?php

declare(strict_types=1);

namespace App\Tests\Unit\ScoreCalculator\Application;

use App\ScoreCalculator\Application\TermScoreCalculator;
use App\ScoreCalculator\Application\TermScoreDataFetcherInterface;
use App\ScoreCalculator\Domain\TermScoreResultValue;
use App\ScoreCalculator\Domain\TermScoreValue;
use PHPUnit\Framework\TestCase;

class TermScoreCalculatorTest extends TestCase
{
    public function test_it_calculates_term_score_correctly()
    {
        $dataFetcher = $this->getMockBuilder(TermScoreDataFetcherInterface::class)
            ->onlyMethods(['getTermValuationData'])
            ->getMock()
        ;

        $termScoreValue = TermScoreValue::from(1, 9);
        $termScoreResult = TermScoreResultValue::from('test', 0.1);

        $dataFetcher->expects($this->once())
            ->method('getTermValuationData')
            ->willReturn($termScoreValue)
        ;

        $termScoreCalculator = new TermScoreCalculator($dataFetcher);

        $this->assertEquals($termScoreCalculator->calculateScoreForTerm('test'), $termScoreResult);
    }
}
