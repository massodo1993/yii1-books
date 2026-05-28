<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle); ?> — Каталог книг</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 16px; }
        header { background: #2c3e50; color: #fff; padding: 12px 0; }
        header .container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
        header a { color: #ecf0f1; text-decoration: none; margin-right: 12px; }
        header a:hover { text-decoration: underline; }
        nav a { font-size: 14px; }
        main { padding: 24px 0; }
        .flash-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px 16px; margin-bottom: 16px; border-radius: 4px; }
        .flash-error   { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px 16px; margin-bottom: 16px; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px 12px; border: 1px solid #dee2e6; text-align: left; }
        th { background: #e9ecef; font-weight: bold; }
        tr:hover { background: #f8f9fa; }
        .btn { display: inline-block; padding: 7px 14px; border-radius: 4px; text-decoration: none; font-size: 14px; cursor: pointer; border: none; }
        .btn-primary   { background: #3498db; color: #fff; }
        .btn-success   { background: #27ae60; color: #fff; }
        .btn-danger    { background: #e74c3c; color: #fff; }
        .btn-secondary { background: #95a5a6; color: #fff; }
        .btn:hover { opacity: .85; }
        form label { display: block; margin-bottom: 4px; font-weight: bold; font-size: 14px; }
        form input[type=text], form input[type=password], form input[type=email],
        form input[type=number], form input[type=file], form textarea, form select {
            width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;
        }
        form textarea { height: 120px; resize: vertical; }
        .form-group { margin-bottom: 14px; }
        .error-summary { background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 14px; }
        .error-summary ul { margin-left: 16px; font-size: 14px; color: #721c24; }
        .field-error { color: #e74c3c; font-size: 13px; margin-top: 2px; }
        .cover-img { max-width: 200px; max-height: 280px; object-fit: cover; border-radius: 4px; }
        .actions { margin-bottom: 16px; display: flex; gap: 8px; flex-wrap: wrap; }
        h1 { font-size: 24px; margin-bottom: 16px; }
        h2 { font-size: 20px; margin-bottom: 12px; }
        .detail-table th { width: 200px; }
    </style>
</head>
<body>
<header>
    <div class="container">
        <a href="<?php echo Yii::app()->createUrl('/book/index'); ?>" style="font-size:18px;font-weight:bold;">📚 Каталог книг</a>
        <nav>
            <a href="<?php echo Yii::app()->createUrl('/book/index'); ?>">Книги</a>
            <a href="<?php echo Yii::app()->createUrl('/author/index'); ?>">Авторы</a>
            <a href="<?php echo Yii::app()->createUrl('/report/index'); ?>">ТОП-10</a>
            <?php if (Yii::app()->user->isGuest): ?>
                <a href="<?php echo Yii::app()->createUrl('/site/login'); ?>">Войти</a>
                <a href="<?php echo Yii::app()->createUrl('/site/register'); ?>">Регистрация</a>
            <?php else: ?>
                <a href="<?php echo Yii::app()->createUrl('/book/create'); ?>">+ Книга</a>
                <a href="<?php echo Yii::app()->createUrl('/author/create'); ?>">+ Автор</a>
                <?php echo CHtml::encode(Yii::app()->user->name); ?>
                <a href="<?php echo Yii::app()->createUrl('/site/logout'); ?>">Выйти</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="flash-success"><?php echo CHtml::encode(Yii::app()->user->getFlash('success')); ?></div>
        <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('error')): ?>
            <div class="flash-error"><?php echo CHtml::encode(Yii::app()->user->getFlash('error')); ?></div>
        <?php endif; ?>

        <?php echo $content; ?>
    </div>
</main>
</body>
</html>
