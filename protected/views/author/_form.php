<?php
/** @var Author $model */
$this->pageTitle = $model->isNewRecord ? 'Добавить автора' : 'Редактировать автора';
?>
<h1><?php echo $this->pageTitle; ?></h1>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'author-form',
    'enableClientValidation' => true,
)); ?>

<?php echo $form->errorSummary($model, null, null, array('class' => 'error-summary')); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'full_name'); ?>
    <?php echo $form->textField($model, 'full_name', array('maxlength' => 255, 'style' => 'max-width:400px;')); ?>
    <?php echo $form->error($model, 'full_name', array('class' => 'field-error')); ?>
</div>

<div style="display:flex;gap:8px;">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class' => 'btn btn-success')); ?>
    <a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/author/index'); ?>">Отмена</a>
</div>

<?php $this->endWidget(); ?>
