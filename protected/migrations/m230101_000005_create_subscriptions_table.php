<?php

class m230101_000005_create_subscriptions_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('subscriptions', array(
            'id'         => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'phone'      => 'VARCHAR(20) NOT NULL COMMENT "номер телефона в формате +7XXXXXXXXXX"',
            'author_id'  => 'INT UNSIGNED NOT NULL',
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'UNIQUE KEY uq_sub_phone_author (phone, author_id)',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addForeignKey(
            'fk_sub_author', 'subscriptions', 'author_id', 'authors', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function down(): void
    {
        $this->dropForeignKey('fk_sub_author', 'subscriptions');
        $this->dropTable('subscriptions');
    }
}
