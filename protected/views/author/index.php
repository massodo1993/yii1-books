<?php
/** @var CActiveDataProvider $dataProvider */
$this->pageTitle = 'Авторы';
?>
    <h1>Авторы</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="actions">
        <a class="btn btn-success" href="<?php echo Yii::app()->createUrl('/author/create'); ?>">+ Добавить автора</a>
    </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'full_name',
        array(
            'header'   => 'Кол-во книг',
            'sortable' => false,
            'type'     => 'raw',
            'value'    => function($data) {
                return count($data->books);
            },
        ),
        array(
            'header'   => 'Действия',
            'sortable' => false,
            'type'     => 'raw',
            'value'    => function($data) {
                $viewUrl = Yii::app()->createUrl('/author/view', array('id' => $data->id));
                $html = '<a href="' . $viewUrl . '" class="btn btn-secondary" style="font-size:12px;padding:3px 8px;">Просмотр</a> ';

                if (Yii::app()->user->isGuest) {
                    $subscribeUrl = Yii::app()->createUrl('/subscription/create', array('authorId' => $data->id));
                    $html .= '<a href="' . $subscribeUrl . '" class="btn btn-primary" style="font-size:12px;padding:3px 8px;">Подписаться</a>';
                } else {
                    $updateUrl = Yii::app()->createUrl('/author/update', array('id' => $data->id));
                    $deleteUrl = Yii::app()->createUrl('/author/delete', array('id' => $data->id));
                    $html .= '<a href="' . $updateUrl . '" class="btn btn-primary" style="font-size:12px;padding:3px 8px;">Изменить</a> ';
                    $html .= '<a href="' . $deleteUrl . '" class="btn btn-danger" style="font-size:12px;padding:3px 8px;" onclick="return confirm(\'Удалить?\')">Удалить</a>';
                }

                return $html;
            },
        ),
    ),
)); ?>