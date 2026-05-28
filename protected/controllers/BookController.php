<?php

class BookController extends CController
{
    public $layout = '//layouts/main';

    public function filters(): array
    {
        return array('accessControl');
    }

    public function accessRules(): array
    {
        return array(
            // Просмотр — всем
            array('allow', 'actions' => array('index', 'view'), 'users' => array('*')),
            // CRUD — только авторизованным
            array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
            // Остальное — запрещено
            array('deny', 'users' => array('*')),
        );
    }

    public function actionIndex(): void
    {
        $model = new Book('search');
        $model->unsetAttributes();
        if (isset($_GET['Book'])) {
            $model->attributes = $_GET['Book'];
        }

        $this->render('index', array('dataProvider' => $model->search()));
    }

    public function actionView(int $id): void
    {
        $book = $this->loadModel($id);
        $this->render('view', array('model' => $book));
    }

    public function actionCreate(): void
    {
        $model = new Book();

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $model->authorIds  = $_POST['Book']['authorIds'] ?? array();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Книга успешно добавлена.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('_form', array('model' => $model, 'authors' => $this->getAuthorsMap()));
    }

    public function actionUpdate(int $id): void
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $model->authorIds  = $_POST['Book']['authorIds'] ?? array();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Книга обновлена.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('_form', array('model' => $model, 'authors' => $this->getAuthorsMap()));
    }

    public function actionDelete(int $id): void
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            Yii::app()->user->setFlash('success', 'Книга удалена.');
        }
        $this->redirect(array('index'));
    }


    private function loadModel(int $id): Book
    {
        $model = Book::model()->with('authors')->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Книга не найдена.');
        }
        return $model;
    }

    private function getAuthorsMap(): array
    {
        return CHtml::listData(Author::model()->findAll(array('order' => 'full_name ASC')), 'id', 'full_name');
    }
}
