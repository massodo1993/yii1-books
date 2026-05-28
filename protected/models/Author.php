<?php

class Author extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'authors';
    }

    public function rules(): array
    {
        return array(
            array('full_name', 'required'),
            array('full_name', 'length', 'max' => 255),
            array('id, full_name', 'safe', 'on' => 'search'),
        );
    }

    public function relations(): array
    {
        return array(
            // Книги автора (через pivot)
            'books'         => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'),
            // Подписчики
            'subscriptions' => array(self::HAS_MANY, 'Subscription', 'author_id'),
        );
    }

    public function attributeLabels(): array
    {
        return array(
            'id'        => 'ID',
            'full_name' => 'ФИО автора',
            'created_at' => 'Добавлен',
        );
    }

    public function search(): CActiveDataProvider
    {
        $criteria = new CDbCriteria();
        $criteria->compare('id',        $this->id);
        $criteria->compare('full_name', $this->full_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder' => 'full_name ASC'),
        ));
    }
}
