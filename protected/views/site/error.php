<?php
$this->pageTitle = 'Ошибка ' . $code;
?>
<h1>Ошибка <?php echo (int)$code; ?></h1>
<p><?php echo CHtml::encode($message); ?></p>
<a class="btn btn-secondary" href="<?php echo Yii::app()->createUrl('/book/index'); ?>">← На главную</a>
