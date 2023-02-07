<?php

declare(strict_types=1);

namespace App\Verification\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206205526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create migration for verification entity';
    }

    public function up(Schema $schema): void
    {
        //warning - postgresql dependant
        $this->addSql('CREATE TABLE verification (id SERIAL PRIMARY KEY, type VARCHAR(255) NOT NULL, identity VARCHAR(255) NOT NULL, confirmed BOOLEAN DEFAULT false NOT NULL, code INTEGER NOT NULL, user_info VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE verification');
    }
}
