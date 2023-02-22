<?php

namespace App\Notification\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230222160000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('notifications');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('recipient', 'string', ['length' => 255]);
        $table->addColumn('channel', 'string', ['length' => 255]);
        $table->addColumn('body', 'text');
        $table->addColumn('dispatched', 'boolean', ['default' => false]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('notifications');
    }
}