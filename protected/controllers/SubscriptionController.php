<?php

class SubscriptionController extends CController
{
    public $layout = '//layouts/main';

    public function filters(): array
    {
        return array('accessControl');
    }

    public function accessRules(): array
    {
        return array(
            array('allow', 'actions' => array('create'), 'users' => array('?')),
            array('deny',  'users' => array('*')),
        );
    }

    public function actionCreate(int $authorId): void
    {
        $author = Author::model()->findByPk($authorId);
        if ($author === null) {
            throw new CHttpException(404, 'Автор не найден.');
        }

        $model            = new Subscription();
        $model->author_id = $authorId;

        if (isset($_POST['Subscription'])) {
            $model->attributes = $_POST['Subscription'];
            $model->author_id  = $authorId;

            if ($model->save()) {
                Yii::app()->user->setFlash('success',
                    "Вы успешно подписались на новые книги автора «{$author->full_name}»."
                );
                $this->redirect(array('/author/view', 'id' => $authorId));
            }
        }

        $this->render('create', array('model' => $model, 'author' => $author));
    }
}
