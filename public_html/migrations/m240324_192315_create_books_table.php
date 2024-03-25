<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240324_192315_create_books_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer(),
            'description' => $this->text(),
            'isbn' => $this->string()->unique(),
            'photo' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('books');
    }
}
