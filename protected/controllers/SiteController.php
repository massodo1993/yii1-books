<?php

class SiteController extends CController
{
    public $layout = '//layouts/main';

    public function actionIndex(): void
    {
        $this->redirect(array('/book/index'));
    }

    public function actionLogin(): void
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('/book/index'));
        }

        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->login()) {
                $this->redirect(Yii::app()->user->returnUrl ?: array('/book/index'));
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout(): void
    {
        Yii::app()->user->logout();
        $this->redirect(array('/book/index'));
    }

    public function actionRegister(): void
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('/book/index'));
        }

        $model = new User();
        $model->setScenario('register');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $identity = new UserIdentity($model->username, $_POST['User']['password']);
                $identity->authenticate();
                Yii::app()->user->login($identity, 0);

                Yii::app()->user->setFlash('success', 'Добро пожаловать, ' . $model->username . '!');
                $this->redirect(array('/book/index'));
            }
        }

        $this->render('register', array('model' => $model));
    }

    public function actionError(): void
    {
        $error = Yii::app()->errorHandler->error;
        if ($error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
}
