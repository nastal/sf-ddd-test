<?php

declare(strict_types=1);

namespace App\Template\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Shared\Domain\Entity\Type;

final class Version20230216123456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create templates table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('templates');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('slug', 'string', ['length' => 255]);
        $table->addColumn('content', 'text');
        $table->setPrimaryKey(['id']);
        $table->addIndex(['slug']);
    }

    public function postUp(Schema $schema): void
    {
        $conn = $this->connection;

        // Insert email-verification entity
        $conn->exec("INSERT INTO templates (slug, content) VALUES ('email-verification', '<!DOCTYPE html><html><head><title>Email verification</title><style>.content {margin: auto;width: 600px;}</style></head><body><div class=\"content\"><p>Your verification code is {{ code }}.</p></div></body></html>')");

        // Insert sms-verification entity
        $conn->exec("INSERT INTO templates (slug, content) VALUES ('sms-verification', 'Your verification code is {{ code }}.')");
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('templates');
    }
}
