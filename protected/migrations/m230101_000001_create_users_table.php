<?php

class m230101_000001_create_users_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('users', array(
            'id'            => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'username'      => 'VARCHAR(64) NOT NULL',
            'email'         => 'VARCHAR(128) NOT NULL',
            'password_hash' => 'VARCHAR(255) NOT NULL',
            'created_at'    => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('uq_users_username', 'users', 'username', true);
        $this->createIndex('uq_users_email',    'users', 'email',    true);
    }

    public function down(): void
    {
        $this->dropTable('users');
    }
}
