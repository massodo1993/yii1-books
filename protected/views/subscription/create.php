<?php
/**
 * @var Subscription $model
 * @var Author       $author
 */
$this->pageTitle = 'Подписка на автора';
?>
<h1>Подписка на новые книги</h1>

<p>Вы подписываетесь на уведомления о новых книгах автора
   <strong><?php echo CHtml::encode($author->full_name); ?></strong>.</p>
<p>При добавлении новой книги вы получите SMS на указанный номер.</p>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'subscription-form',
    'enableClientValidation' => true,
)); ?>

<?php echo $form->errorSummary($model, null, null, array('class' => 'error-summary')); ?>

<div class="form-group" style="max-width:320px;">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', array('placeholder' => '+79991234567', 'maxlength' => 20)); ?>
    <?php echo $form->error($model, 'phone', array('class' => 'field-error')); ?>
</div>

<?php echo $form->hiddenField($model, 'author_id'); ?>

<div style="display:flex;gap:8px;">
    <?php echo CHtml::submitButton('Подписаться', array('class' => 'btn btn-success')); ?>
    <a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/author/view', array('id' => $author->id)); ?>">Отмена</a>
</div>

<?php $this->endWidget(); ?>
