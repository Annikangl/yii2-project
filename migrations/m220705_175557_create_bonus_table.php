<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bonus}}`.
 */
class m220705_175557_create_bonus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp(),
            'employee_id' => $this->integer(),
            'cost' => $this->integer()
        ]);

        $this->createIndex('idx-bonus-employee_id', 'bonus', 'employee_id');

        $this->addForeignKey('fk_bonus_employee_id', 'bonus', 'employee_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bonus}}');
    }
}
