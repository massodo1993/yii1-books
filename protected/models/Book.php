<?php

class Book extends CActiveRecord
{
    public $coverFile = null;
    public $authorIds = array();
    private $wasNewRecord = false;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'books';
    }

    public function rules(): array
    {
        return array(
            array('title, year', 'required'),
            array('title',       'length', 'max' => 255),
            array('year',        'numerical', 'integerOnly' => true, 'min' => 1000, 'max' => 9999),
            array('isbn',        'length', 'max' => 20),
            array('isbn',        'unique'),
            array('description', 'safe'),
            array('coverFile',   'file', 'types' => 'jpg,jpeg,png,gif,webp', 'allowEmpty' => true),
            array('authorIds',   'safe'),
            array('id, title, year, isbn', 'safe', 'on' => 'search'),
        );
    }

    public function relations(): array
    {
        return array(
            'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
        );
    }

    public function attributeLabels(): array
    {
        return array(
            'id'          => 'ID',
            'title'       => 'Название',
            'year'        => 'Год выпуска',
            'description' => 'Описание',
            'isbn'        => 'ISBN',
            'cover_image' => 'Обложка',
            'coverFile'   => 'Загрузить обложку',
            'authorIds'   => 'Авторы',
            'created_at'  => 'Добавлена',
        );
    }

    protected function afterFind(): void
    {
        $this->authorIds = array_map(
            fn(Author $a) => $a->id,
            $this->authors
        );
        parent::afterFind();
    }

    protected function beforeSave(): bool
    {
        $this->wasNewRecord = $this->isNewRecord;

        $this->coverFile = CUploadedFile::getInstance($this, 'coverFile');
        if ($this->coverFile !== null) {
            $uploadDir = Yii::app()->basePath . '/../uploads/covers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid('cover_', true) . '.' . $this->coverFile->extensionName;
            if (!$this->coverFile->saveAs($uploadDir . $fileName)) {
                return false;
            }

            if ($this->cover_image && file_exists(Yii::app()->basePath . '/../uploads/' . $this->cover_image)) {
                unlink(Yii::app()->basePath . '/../uploads/' . $this->cover_image);
            }

            $this->cover_image = 'covers/' . $fileName;
        }

        return parent::beforeSave();
    }

    protected function afterSave(): void
    {
        $this->saveAuthors();

        if ($this->wasNewRecord) {
            $this->notifySubscribers();
        }

        parent::afterSave();
    }

    private function saveAuthors(): void
    {
        Yii::app()->db->createCommand()
            ->delete('book_author', 'book_id = :id', array(':id' => $this->id));

        foreach ($this->authorIds as $authorId) {
            Yii::app()->db->createCommand()->insert('book_author', array(
                'book_id'   => $this->id,
                'author_id' => (int)$authorId,
            ));
        }
    }

    private function notifySubscribers(): void
    {
        $subscriptions = Subscription::model()->findAllByAttributes(
            array(),
            array(
                'condition' => 'author_id IN (' . implode(',', array_map('intval', $this->authorIds)) . ')',
            )
        );

        if (empty($subscriptions)) {
            return;
        }

        $sms = new SmsPilot();
        $authorNames = array_map(fn(Author $a) => $a->full_name, $this->authors);
        $message = sprintf(
            'Новая книга "%s" (%d) от %s.',
            $this->title,
            $this->year,
            implode(', ', $authorNames)
        );

        $phones = array_unique(array_map(fn(Subscription $s) => $s->phone, $subscriptions));
        foreach ($phones as $phone) {
            $sms->send($phone, $message);
        }
    }

    public function search(): CActiveDataProvider
    {
        $criteria = new CDbCriteria();
        $criteria->compare('id',    $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('year',  $this->year);
        $criteria->compare('isbn',  $this->isbn, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder' => 'created_at DESC'),
        ));
    }
}