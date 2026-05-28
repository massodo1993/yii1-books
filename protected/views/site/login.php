<?php
/** @var LoginForm $model */
$this->pageTitle = 'Вход';
?>
<h1>Вход</h1>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
)); ?>

<?php echo $form->errorSummary($model, null, null, array('class' => 'error-summary')); ?>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'username'); ?>
    <?php echo $form->textField($model, 'username'); ?>
    <?php echo $form->error($model, 'username', array('class' => 'field-error')); ?>
</div>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password'); ?>
    <?php echo $form->error($model, 'password', array('class' => 'field-error')); ?>
</div>

<?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-primary')); ?>
<a style="margin-left:12px;" href="<?php echo Yii::app()->createUrl('/site/register'); ?>">Нет аккаунта? Зарегистрироваться</a>

<?php $this->endWidget(); ?>
