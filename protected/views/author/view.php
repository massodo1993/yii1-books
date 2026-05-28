<?php
/** @var Author $model */
$this->pageTitle = CHtml::encode($model->full_name);
?>
<h1><?php echo CHtml::encode($model->full_name); ?></h1>

<div class="actions">
    <a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/author/index'); ?>">← К списку</a>
    <?php if (!Yii::app()->user->isGuest): ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/author/update', array('id' => $model->id)); ?>">Редактировать</a>
        <?php echo CHtml::form(array('/author/delete', 'id' => $model->id), 'post'); ?>
        <?php echo CHtml::submitButton('Удалить', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Удалить автора?");')); ?>
        <?php echo CHtml::endForm(); ?>
    <?php else: ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/subscription/create', array('authorId' => $model->id)); ?>">
            🔔 Подписаться на новые книги
        </a>
    <?php endif; ?>
</div>

<h2>Книги автора</h2>
<?php if ($model->books): ?>
    <table>
        <thead><tr><th>Название</th><th>Год</th><th>ISBN</th></tr></thead>
        <tbody>
        <?php foreach ($model->books as $book): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($book->title), array('/book/view', 'id' => $book->id)); ?></td>
                <td><?php echo $book->year; ?></td>
                <td><?php echo CHtml::encode($book->isbn ?: '—'); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Книг пока нет.</p>
<?php endif; ?>
