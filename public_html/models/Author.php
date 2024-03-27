<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $fio
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }

    public function getBooksWithYear($year)
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id'], function ($query) use ($year) {
                $query->andWhere(['year' => $year]);
            });
    }

    public static function getPopular($year)
    {
        if (is_null($year)) {
            return [];
        }
        return Author::find()
            ->select(['authors.id', 'authors.fio', 'COUNT(books.id) as book_count'])
            ->joinWith(['books' => function ($query) use ($year) {
                $query->andWhere(['year' => $year]);
            }])
            ->groupBy('authors.id')
            ->orderBy(new Expression('book_count DESC'))
            ->limit(10)
            ->all();
    }
}
