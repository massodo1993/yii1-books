<?php

return array(
    'roles' => array(
        'guest' => array(
            'type'    => CAuthItem::TYPE_ROLE,
            'description' => 'Неаутентифицированный пользователь',
            'bizRule' => 'return Yii::app()->user->isGuest;',
            'children' => array('viewContent', 'subscribe'),
        ),
        'user' => array(
            'type'    => CAuthItem::TYPE_ROLE,
            'description' => 'Аутентифицированный пользователь',
            'bizRule' => 'return !Yii::app()->user->isGuest;',
            'children' => array('viewContent', 'manageContent'),
        ),
    ),
    'tasks' => array(
        'viewContent' => array(
            'type'        => CAuthItem::TYPE_TASK,
            'description' => 'Просмотр книг и авторов',
            'children'    => array('viewBook', 'viewAuthor', 'viewReport'),
        ),
        'manageContent' => array(
            'type'        => CAuthItem::TYPE_TASK,
            'description' => 'Управление книгами и авторами',
            'children'    => array('createBook', 'updateBook', 'deleteBook', 'createAuthor', 'updateAuthor', 'deleteAuthor'),
        ),
    ),
    'operations' => array(
        'viewBook'     => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Просмотр книги'),
        'viewAuthor'   => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Просмотр автора'),
        'viewReport'   => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Просмотр отчёта'),
        'subscribe'    => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Подписка на автора'),
        'createBook'   => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Создание книги'),
        'updateBook'   => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Редактирование книги'),
        'deleteBook'   => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Удаление книги'),
        'createAuthor' => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Создание автора'),
        'updateAuthor' => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Редактирование автора'),
        'deleteAuthor' => array('type' => CAuthItem::TYPE_OPERATION, 'description' => 'Удаление автора'),
    ),
);
