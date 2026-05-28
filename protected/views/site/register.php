<?php
/** @var User $model */
$this->pageTitle = 'Регистрация';
?>
<h1>Регистрация</h1>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'register-form',
    'enableClientValidation' => true,
)); ?>

<?php echo $form->errorSummary($model, null, null, array('class' => 'error-summary')); ?>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'username'); ?>
    <?php echo $form->textField($model, 'username'); ?>
    <?php echo $form->error($model, 'username', array('class' => 'field-error')); ?>
</div>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->emailField($model, 'email'); ?>
    <?php echo $form->error($model, 'email', array('class' => 'field-error')); ?>
</div>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password'); ?>
    <?php echo $form->error($model, 'password', array('class' => 'field-error')); ?>
</div>

<div class="form-group" style="max-width:360px;">
    <?php echo $form->labelEx($model, 'password_repeat'); ?>
    <?php echo $form->passwordField($model, 'password_repeat'); ?>
    <?php echo $form->error($model, 'password_repeat', array('class' => 'field-error')); ?>
</div>

<?php echo CHtml::submitButton('Зарегистрироваться', array('class' => 'btn btn-success')); ?>
<a style="margin-left:12px;" href="<?php echo Yii::app()->createUrl('/site/login'); ?>">Уже есть аккаунт? Войти</a>

<?php $this->endWidget(); ?>
