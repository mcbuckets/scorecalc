<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use App\ScoreCalculator\Domain\Model\TermScore;
use App\ScoreCalculator\Domain\Model\TermScoreRepositoryInterface;

final class TermScoreRepository implements TermScoreRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneByTerm(string $term): ?TermScore
    {
        return $this->entityManager->getRepository(TermScore::class)
            ->findOneBy(['term' => $term]);
    }

    public function save(TermScore $termScore): void
    {
        $this->entityManager->persist($termScore);
        $this->entityManager->flush();
    }
}
