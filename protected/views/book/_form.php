<?php
/**
 * @var Book  $model
 * @var array $authors  [id => full_name]
 */
$this->pageTitle = $model->isNewRecord ? 'Добавить книгу' : 'Редактировать книгу';
?>
<h1><?php echo $this->pageTitle; ?></h1>

<a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/book/index'); ?>">← Назад</a>
<br><br>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'book-form',
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
    'enableClientValidation' => true,
)); ?>

<?php echo $form->errorSummary($model, 'Пожалуйста, исправьте ошибки:', null, array('class' => 'error-summary')); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('maxlength' => 255)); ?>
    <?php echo $form->error($model, 'title', array('class' => 'field-error')); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'year'); ?>
    <?php echo $form->numberField($model, 'year', array('min' => 1000, 'max' => 9999)); ?>
    <?php echo $form->error($model, 'year', array('class' => 'field-error')); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'isbn'); ?>
    <?php echo $form->textField($model, 'isbn', array('maxlength' => 20)); ?>
    <?php echo $form->error($model, 'isbn', array('class' => 'field-error')); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textArea($model, 'description'); ?>
    <?php echo $form->error($model, 'description', array('class' => 'field-error')); ?>
</div>

<div class="form-group">
    <label>Авторы</label>
    <?php if (empty($authors)): ?>
        <p>Авторы ещё не добавлены. <a href="<?php echo Yii::app()->createUrl('/author/create'); ?>">Добавить автора</a></p>
    <?php else: ?>
        <?php echo CHtml::listBox(
            'Book[authorIds][]',
            $model->authorIds,
            $authors,
            array('multiple' => 'multiple', 'size' => min(8, count($authors)), 'style' => 'width:100%;max-width:400px;')
        ); ?>
        <small style="color:#888;">Удерживайте Ctrl (или Cmd на Mac) для выбора нескольких авторов</small>
    <?php endif; ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'coverFile'); ?>
    <?php if ($model->cover_image): ?>
        <div style="margin-bottom:8px;">
            <img src="<?php echo Yii::app()->request->baseUrl . '/uploads/' . $model->cover_image; ?>"
                 style="height:80px;object-fit:cover;border-radius:4px;" alt="Текущая обложка">
            <small>(загрузите новый файл, чтобы заменить)</small>
        </div>
    <?php endif; ?>
    <?php echo $form->fileField($model, 'coverFile', array('accept' => 'image/jpeg,image/png,image/gif,image/webp')); ?>
    <?php echo $form->error($model, 'coverFile', array('class' => 'field-error')); ?>
</div>

<div style="display:flex;gap:8px;">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class' => 'btn btn-success')); ?>
    <a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/book/index'); ?>">Отмена</a>
</div>

<?php $this->endWidget(); ?>
