<?php

/**
 * Аутентификация пользователя.
 * Используется в CWebUser::login().
 */
class UserIdentity extends CUserIdentity
{
    private ?int $_id = null;

    public function authenticate(): bool
    {
        $user = User::findByUsername($this->username);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }

        $this->_id       = $user->id;
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

    public function getId(): ?int
    {
        return $this->_id;
    }
}
