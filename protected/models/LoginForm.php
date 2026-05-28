<?php

class LoginForm extends CFormModel
{
    public string $username = '';
    public string $password = '';

    private ?User $_user = null;

    public function rules(): array
    {
        return array(
            array('username, password', 'required'),
            array('password',           'authenticate'),
        );
    }

    public function attributeLabels(): array
    {
        return array(
            'username' => 'Логин',
            'password' => 'Пароль',
        );
    }

    public function authenticate(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = User::findByUsername($this->username);
        if ($user === null || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный логин или пароль.');
        } else {
            $this->_user = $user;
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $identity = new UserIdentity($this->username, $this->password);
        $identity->authenticate();
        return Yii::app()->user->login($identity, 0);
    }
}
