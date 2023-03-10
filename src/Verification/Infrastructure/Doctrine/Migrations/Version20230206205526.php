<?php

declare(strict_types=1);

namespace App\Verification\Infrastructure\Doctrine\Migrations;

use App\Shared\Domain\Service\UlidService;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;


final class Version20230206205526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create migration for verification entity';
    }

    public function up(Schema $schema): void
    {
        //warning - postgresql dependant
        $table = $schema->createTable('verification');
        $table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('uuid', 'string', ['notnull' => true]);
        $table->addColumn('type', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('identity', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('confirmed', 'boolean', ['notnull' => false]);
        $table->addColumn('code', 'integer', ['notnull' => false]);
        $table->addColumn('user_fingerprint', 'string', ['notnull' => false]);
        $table->addColumn('ip_address', 'string', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('invalid_attempts', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['identity', 'type']);
    }

    public function postUp(Schema $schema): void
    {
        $conn = $this->connection;
        $conn->exec("INSERT INTO verification (uuid, type, identity, confirmed, code, user_fingerprint, created_at, invalid_attempts, ip_address) VALUES ('". Uuid::uuid5(Uuid::NAMESPACE_OID, UlidService::generate())."', 'email', 'test@test.com', true, 123456, 'test-user-fingerprint', NOW(), 0, '::1')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('verification');
    }
}
