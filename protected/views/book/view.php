<?php
/** @var Book $model */
$this->pageTitle = CHtml::encode($model->title);
?>
<h1><?php echo CHtml::encode($model->title); ?></h1>

<div class="actions">
    <a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/book/index'); ?>">← К списку</a>
    <?php if (!Yii::app()->user->isGuest): ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/book/update', array('id' => $model->id)); ?>">Редактировать</a>
        <?php echo CHtml::form(array('/book/delete', 'id' => $model->id), 'post'); ?>
        <?php echo CHtml::submitButton('Удалить', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Удалить книгу?");')); ?>
        <?php echo CHtml::endForm(); ?>
    <?php endif; ?>
</div>

<div style="display:flex;gap:24px;flex-wrap:wrap;">
    <?php if ($model->cover_image): ?>
    <div>
        <img class="cover-img"
             src="<?php echo Yii::app()->request->baseUrl . '/uploads/' . $model->cover_image; ?>"
             alt="<?php echo CHtml::encode($model->title); ?>">
    </div>
    <?php endif; ?>

    <div style="flex:1;min-width:280px;">
        <table class="detail-table">
            <tr><th>Название</th><td><?php echo CHtml::encode($model->title); ?></td></tr>
            <tr><th>Год выпуска</th><td><?php echo $model->year; ?></td></tr>
            <tr><th>ISBN</th><td><?php echo CHtml::encode($model->isbn ?: '—'); ?></td></tr>
            <tr>
                <th>Авторы</th>
                <td>
                    <?php if ($model->authors): ?>
                        <?php foreach ($model->authors as $author): ?>
                            <?php echo CHtml::link(CHtml::encode($author->full_name), array('/author/view', 'id' => $author->id)); ?>
                            <?php if (Yii::app()->user->isGuest): ?>
                                <small>(<a href="<?php echo Yii::app()->createUrl('/subscription/create', array('authorId' => $author->id)); ?>">подписаться</a>)</small>
                            <?php endif; ?><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <tr><th>Добавлена</th><td><?php echo $model->created_at; ?></td></tr>
        </table>

        <?php if ($model->description): ?>
            <h2 style="margin-top:16px;">Описание</h2>
            <p><?php echo nl2br(CHtml::encode($model->description)); ?></p>
        <?php endif; ?>
    </div>
</div>
