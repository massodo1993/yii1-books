<?php
/** @var CActiveDataProvider $dataProvider */
$this->pageTitle = 'Книги';
?>
<h1>Каталог книг</h1>

<?php if (!Yii::app()->user->isGuest): ?>
<div class="actions">
    <a class="btn btn-success" href="<?php echo Yii::app()->createUrl('/book/create'); ?>">+ Добавить книгу</a>
</div>
<?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name'  => 'cover_image',
            'header' => 'Обложка',
            'type' => 'raw',
            'value' => function($data) {
                if ($data->cover_image) {
                    $url = Yii::app()->request->baseUrl . '/uploads/' . $data->cover_image;
                    return CHtml::image($url, $data->title, array('style' => 'height:60px;object-fit:cover;border-radius:2px;'));
                }
                return '—';
            },
        ),
        array(
            'name'  => 'title',
            'header' => 'Название',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link(CHtml::encode($data->title), array('/book/view', 'id' => $data->id));
            },
        ),
        'year',
        'isbn',
        array(
            'name'  => 'authors',
            'header' => 'Авторы',
            'type' => 'raw',
            'sortable' => false,
            'value' => function($data) {
                $names = array_map(fn($a) => CHtml::encode($a->full_name), $data->authors);
                return implode(', ', $names) ?: '—';
            },
        ),
        array(
            'class'    => 'CButtonColumn',
            'template' => Yii::app()->user->isGuest ? '{view}' : '{view}{update}{delete}',
        ),
    ),
)); ?>
