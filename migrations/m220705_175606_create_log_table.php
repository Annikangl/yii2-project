<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 */
class m220705_175606_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp(),
            'user_id' => $this->integer(),
            'message' => $this->text()
        ]);

        $this->createIndex('idx-log-user_id', 'log', 'user_id');

        $this->addForeignKey('fk_log_user_id', 'log', 'user_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log}}');
    }
}
