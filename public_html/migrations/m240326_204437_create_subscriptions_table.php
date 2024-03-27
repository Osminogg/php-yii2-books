<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m240326_204437_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscriptions', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'phone' => $this->bigInteger(),
        ]);

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            'subscriptions',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subscriptions');
    }
}
