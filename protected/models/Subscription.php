<?php

class Subscription extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'subscriptions';
    }

    public function rules(): array
    {
        return array(
            array('phone, author_id', 'required'),
            array('author_id', 'numerical', 'integerOnly' => true),
            array('phone',     'match',
                'pattern' => '/^\+?[0-9]{10,15}$/',
                'message' => 'Введите корректный номер телефона (например +79991234567).',
            ),
            array('phone', 'validateUnique'),
        );
    }

    public function relations(): array
    {
        return array(
            'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
        );
    }

    public function attributeLabels(): array
    {
        return array(
            'phone'     => 'Номер телефона',
            'author_id' => 'Автор',
        );
    }

    public function validateUnique(string $attribute): void
    {
        $exists = self::model()->exists(
            'phone = :phone AND author_id = :author_id',
            array(':phone' => $this->phone, ':author_id' => $this->author_id)
        );
        if ($exists) {
            $this->addError($attribute, 'Вы уже подписаны на этого автора с данным номером.');
        }
    }
}
