<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Application\DataFetcher;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\ScoreCalculator\Domain\VO\TermScoreValue;
use App\ScoreCalculator\Domain\Exception\InvalidGithubData;
use App\ScoreCalculator\Application\TermScoreDataFetcherInterface;

final class GithubTermDataFetcher implements TermScoreDataFetcherInterface
{
    private const SEARCH_ISSUES_URI = 'https://api.github.com/search/issues';
    private const POSITIVE_TERM_VALUATION = 'rocks';
    private const NEGATIVE_TERM_VALUATION = 'sucks';

    public function __construct(
        private HttpClientInterface $httpClient, // this should not be here. should have used application layer interface
    ) {
    }

    public function getTermValuationData(string $term): TermScoreValue
    {
        return TermScoreValue::from(
            $this->fetchPositiveValuationResults($term),
            $this->fetchNegativeValuationResults($term)
        );
    }

    private function fetchPositiveValuationResults(string $term): int
    {
        return $this->fetchDataForTerm($term . ' ' . self::POSITIVE_TERM_VALUATION);
    }

    private function fetchNegativeValuationResults(string $term): int
    {
        return $this->fetchDataForTerm($term . ' ' . self::NEGATIVE_TERM_VALUATION);
    }

    /**
     * @throws InvalidGithubData
     */
    private function fetchDataForTerm(string $term): int|Exception
    {
        try {
            $response = $this->httpClient->request('GET', self::SEARCH_ISSUES_URI, [
                'query' => ['q' => $term],
            ]);

            $data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

            return $data['total_count'] ?? throw InvalidGithubData::invalidDataException();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
