<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property int|null $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $photo
 * @property array $author_ids
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
            [['author_ids'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public static function getAvailableYears()
    {
        return self::find()
            ->select('year')
            ->distinct()
            ->where(['IS NOT', 'year', null])
            ->column();
    }

    public function saveModel($author_ids)
    {
        $this->unlinkAll('authors', true);
        if (!empty($author_ids)) {
            if ($this->isNewRecord) {
                $this->save();
            }
            foreach ($author_ids as $authorId) {
                $author = Author::findOne($authorId);
                if ($author) {
                    $this->link('authors', $author);
                }
            }
        }
        return $this->save();
    }
}
