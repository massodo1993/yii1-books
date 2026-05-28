<?php

class ReportController extends CController
{
    public $layout = '//layouts/main';

    public function actionIndex(): void
    {
        $year = (int)Yii::app()->request->getParam('year', date('Y'));

        $rows = Yii::app()->db->createCommand()
            ->select('a.id, a.full_name, COUNT(ba.book_id) AS book_count')
            ->from('authors a')
            ->join('book_author ba', 'ba.author_id = a.id')
            ->join('books b', 'b.id = ba.book_id')
            ->where('b.year = :year', array(':year' => $year))
            ->group('a.id, a.full_name')
            ->order('book_count DESC, a.full_name ASC')
            ->limit(10)
            ->queryAll();

        $years = $this->getAvailableYears();

        $this->render('index', array(
            'rows'  => $rows,
            'year'  => $year,
            'years' => $years,
        ));
    }

    private function getAvailableYears(): array
    {
        $data = Yii::app()->db->createCommand()
            ->select('DISTINCT year')
            ->from('books')
            ->order('year DESC')
            ->queryColumn();

        return array_combine($data, $data);
    }
}
