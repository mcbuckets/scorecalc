<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Infrastructure\Web\Controller\Rest\v2;

use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

use App\ScoreCalculator\Domain\Model\TermScore;
use App\ScoreCalculator\Application\TermScoreCalculatorInterface;

final class GitHubTermScoreController extends AbstractController
{

    public function __construct(
        private TermScoreCalculatorInterface $termScoreCalculator,
    ){}

    /**
     * @param FilesystemAdapter $githubScorecalcCache
     */
    #[Route(
        path: '/api/v2/score/{term}',
        name: 'scorecalc_api_V2_term_score_calculator_github_get_score',
        requirements: [
            '_format' => 'json',
         ],
        methods: ['GET', 'HEAD'],
    )]
    public function getTermScore(string $term, CacheInterface $githubScorecalcCache): JsonResponse
    {
        $cacheResult = $githubScorecalcCache->get($term, function (ItemInterface $item) use ($term, $githubScorecalcCache) {
            $termScoreResultValue = $this->termScoreCalculator->calculateScoreForTerm($term);
            $termScore = TermScore::fromTermScoreResultValue($termScoreResultValue);
            $item->expiresAt((new DateTimeImmutable())->modify('+5 hours'));

            return $termScore->asArray();
        });

        return new JsonResponse($cacheResult);
    }
}
