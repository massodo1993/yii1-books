<?php

class m230101_000004_create_book_author_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('book_author', array(
            'book_id'   => 'INT UNSIGNED NOT NULL',
            'author_id' => 'INT UNSIGNED NOT NULL',
            'PRIMARY KEY (book_id, author_id)',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addForeignKey(
            'fk_ba_book',   'book_author', 'book_id',   'books',   'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_ba_author', 'book_author', 'author_id', 'authors', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function down(): void
    {
        $this->dropForeignKey('fk_ba_book',   'book_author');
        $this->dropForeignKey('fk_ba_author', 'book_author');
        $this->dropTable('book_author');
    }
}
