<?php

/**
 * CRUD для авторов.
 */
class AuthorController extends CController
{
    public $layout = '//layouts/main';

    public function filters(): array
    {
        return array('accessControl');
    }

    public function accessRules(): array
    {
        return array(
            array('allow', 'actions' => array('index', 'view'), 'users' => array('*')),
            array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
            array('deny',  'users' => array('*')),
        );
    }

    public function actionIndex(): void
    {
        $model = new Author('search');
        $model->unsetAttributes();
        if (isset($_GET['Author'])) {
            $model->attributes = $_GET['Author'];
        }

        $this->render('index', array('dataProvider' => $model->search()));
    }

    public function actionView(int $id): void
    {
        $author = $this->loadModel($id);
        $this->render('view', array('model' => $author));
    }

    public function actionCreate(): void
    {
        $model = new Author();

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Автор добавлен.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate(int $id): void
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Автор обновлён.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('_form', array('model' => $model));
    }

    public function actionDelete(int $id): void
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            Yii::app()->user->setFlash('success', 'Автор удалён.');
        }
        $this->redirect(array('index'));
    }

    private function loadModel(int $id): Author
    {
        $model = Author::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Автор не найден.');
        }
        return $model;
    }
}
