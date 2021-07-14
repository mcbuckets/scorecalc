<?php

declare(strict_types=1);

namespace App\ScoreCalculator\Domain\Exception;

use Exception;

final class InvalidGithubData extends Exception
{
    public static function invalidDataException(): self
    {
        return new self('There was an error fetching GitHub data!');
    }
}
