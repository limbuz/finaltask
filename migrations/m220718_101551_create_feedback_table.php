<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feedback}}`.
 */
class m220718_101551_create_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feedback}}', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer(),
            'title' => $this->string(100),
            'text' => $this->string(255),
            'rating' => $this->integer(),
            'img' => $this->binary(),
            'id_author' => $this->integer(),
            'date_create' => $this->integer(),
        ]);

        $this->addForeignKey('author', '{{%feedback}}', 'id_author', '{{%user}}', 'id');
        $this->addForeignKey('city', '{{%feedback}}', 'id_city', '{{%city}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('id_author', '{{%feedback}}');
        $this->dropForeignKey('id_city', '{{%feedback}}');
        $this->dropTable('{{%feedback}}');
    }
}
