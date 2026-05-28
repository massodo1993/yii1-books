<?php

class m230101_000002_create_authors_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('authors', array(
            'id'         => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'full_name'  => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->dropTable('authors');
    }
}
