<?php

namespace app\models;

use app\jobs\SubscriptionJob;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * ContactForm is the model behind the contact form.
 */
class BookForm extends Model
{
    public ?int $book_id;
    public string $title;
    public ?int $year;
    public string $description;
    public string $isbn;
    public string $photo;
    public array $author_ids;

    public function __construct($config = [])
    {
        $this->book_id = $config['book_id'] ?? null;
        if ($this->book_id) {
            $book = Book::findOne($this->book_id);
            $this->load($book->attributes, '');
            $this->author_ids = ArrayHelper::getColumn($book->authors,'id');
        } else {
            $this->title = '';
            $this->year = null;
            $this->description = '';
            $this->isbn = '';
            $this->photo = '';
            $this->author_ids = [];
        }
        parent::__construct($config);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'year', 'isbn', 'author_ids'], 'required'],
            [['year', 'book_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'unique', 'targetClass' => 'app\models\Book', 'filter' => $this->book_id !== null ? ['<>', 'id', $this->book_id] : [], 'message' => 'Такой isbn уже существует.'],
            [['author_ids'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'isbn',
            'photo' => 'Фото',
            'author_ids' => 'Авторы',
        ];
    }

    public function save()
    {
        $book = Book::findOne($this->book_id);
        if (!$book) {
            $book = new Book();
        }
        $attributes = array_filter($this->attributes, function($key) {
            return $key !== 'author_ids';
        }, ARRAY_FILTER_USE_KEY);
        $book->load($attributes, '');

        $book->unlinkAll('authors', true);
        if (empty($this->author_ids)) {
            return $book->save();
        }

        if ($isNewRecord = $book->isNewRecord) {
            $book->save();
        }
        foreach ($this->author_ids as $authorId) {
            $author = Author::findOne($authorId);
            if (!$author) {
                continue;
            }
            $book->link('authors', $author);

            if ($isNewRecord) {
                Yii::$app->queue->push(new SubscriptionJob([
                    'author_id' => $authorId,
                    'title' => $this->title
                ]));
            }
        }
        return $book->save();
    }
}
