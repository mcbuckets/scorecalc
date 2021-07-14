<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generphp bin/console doctrine:migrations:statusated Migration: Please modify to your needs!
 */
final class Version20210712223902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $wordScoreTable = $schema->createTable('term_scores');
        $wordScoreTable->addColumn('id', 'integer', ['autoincrement' => true]);
        $wordScoreTable->addColumn('term', 'string');
        $wordScoreTable->addColumn('score', 'integer');
        $wordScoreTable->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('word_scores');
    }
}
