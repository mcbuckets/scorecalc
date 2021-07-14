<?php

namespace App\Tests\Integration\ScoreCalculator\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

use App\ScoreCalculator\Application\DataFetcher\GithubTermDataFetcher;
use App\ScoreCalculator\Application\TermScoreDataFetcherInterface;
use App\ScoreCalculator\Domain\Exception\InvalidGithubData;


class GithubTermDataFetcherTest extends TestCase
{
    protected TermScoreDataFetcherInterface $githubDataFetcher;

    protected function setUp(): void
    {
        $httpClient = new MockHttpClient(
            new MockResponse($this->githubDataInvalidResponse())
        );

        $this->githubDataFetcher = new GithubTermDataFetcher($httpClient);
    }

    public function test_it_throws_exception_for_invalid_github_data_for_term()
    {
        $this->expectException(InvalidGithubData::class);

        $this->githubDataFetcher->getTermValuationData('term');
    }

    private function githubDataInvalidResponse(): string
    {
        return json_encode([
            'total_count_key_missing' => true,
            'incomplete_results' => false,
        ]);
    }
}
