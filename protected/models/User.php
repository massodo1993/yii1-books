<?php

class User extends CActiveRecord
{
    public string $password        = '';
    public string $password_repeat = '';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return array(
            array('username, email, password', 'required', 'on' => 'register'),
            array('username',                  'length',   'max' => 64),
            array('email',                     'email'),
            array('email',                     'unique'),
            array('username',                  'unique'),
            array('password_repeat',           'compare', 'compareAttribute' => 'password', 'on' => 'register'),
            array('id, username, email, created_at', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels(): array
    {
        return array(
            'id'       => 'ID',
            'username' => 'Логин',
            'email'    => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'created_at' => 'Дата регистрации',
        );
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord && $this->password !== '') {
            $this->password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        }
        return parent::beforeSave();
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    public static function findByUsername(string $username): ?self
    {
        return self::model()->findByAttributes(array('username' => $username));
    }
}
