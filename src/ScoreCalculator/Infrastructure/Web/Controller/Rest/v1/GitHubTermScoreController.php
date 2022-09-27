<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Infrastructure\Web\Controller\Rest\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\ScoreCalculator\Domain\Model\TermScoreRepositoryInterface;
use App\ScoreCalculator\Domain\Model\TermScore;
use App\ScoreCalculator\Application\TermScoreCalculatorInterface;

final class GitHubTermScoreController extends AbstractController
{

    public function __construct(
        private TermScoreRepositoryInterface $termScoreRepository,
        private TermScoreCalculatorInterface $termScoreCalculator,
    ){}

    #[Route(
        path: '/api/v1/score/{term}',
        name: 'scorecalc_api_v1_term_score_calculator_github_get_score',
        requirements: [
            '_format' => 'json',
         ],
        methods: ['GET', 'HEAD'],
    )]
    public function getTermScore(string $term): JsonResponse
    {
        $termScore = $this->termScoreRepository->findOneByTerm($term);

        if (null !== $termScore) {
            return new JsonResponse($termScore->asArray());
        }

        $termScoreResultValue = $this->termScoreCalculator->calculateScoreForTerm($term);

        $termScore = TermScore::fromTermScoreResultValue($termScoreResultValue);
        $this->termScoreRepository->save($termScore);

        return new JsonResponse($termScore->asArray());
    }
}
