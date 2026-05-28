<?php

class m230101_000003_create_books_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('books', array(
            'id'          => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title'       => 'VARCHAR(255) NOT NULL',
            'year'        => 'SMALLINT UNSIGNED NOT NULL',
            'description' => 'TEXT NULL',
            'isbn'        => 'VARCHAR(20) NULL',
            'cover_image' => 'VARCHAR(512) NULL COMMENT "путь к файлу относительно webroot/uploads/"',
            'created_at'  => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_books_year',  'books', 'year');
        $this->createIndex('uq_books_isbn',   'books', 'isbn',  true);
    }

    public function down(): void
    {
        $this->dropTable('books');
    }
}
