<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m240324_192652_create_authors_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('authors', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('authors');
    }
}
