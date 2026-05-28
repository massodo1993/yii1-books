<?php
/**
 * @var array  $rows   [['id','full_name','book_count'], ...]
 * @var int    $year
 * @var array  $years  [year => year]
 */
$this->pageTitle = 'ТОП-10 авторов';
?>
<h1>ТОП-10 авторов по количеству книг</h1>

<form method="get" style="margin-bottom:20px;display:flex;align-items:center;gap:10px;">
    <label for="year-select" style="font-weight:bold;">Год:</label>
    <?php echo CHtml::dropDownList('year', $year, $years, array(
        'id'    => 'year-select',
        'style' => 'padding:6px 10px;border:1px solid #ccc;border-radius:4px;',
        'empty' => '— выберите год —',
    )); ?>
    <button type="submit" class="btn btn-primary">Показать</button>
</form>

<?php if (empty($rows)): ?>
    <p>Нет данных за <?php echo (int)$year; ?> год.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Автор</th>
                <th>Книг в <?php echo (int)$year; ?> г.</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $row): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td>
                    <?php echo CHtml::link(
                        CHtml::encode($row['full_name']),
                        array('/author/view', 'id' => $row['id'])
                    ); ?>
                </td>
                <td><?php echo (int)$row['book_count']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
