<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%interview}}`.
 */
class m220705_173423_create_interview_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%interview}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string(),
            'status' => $this->smallInteger()->notNull(),
            'reject_reason' => $this->text(),
            'employee_id' => $this->integer(),
        ]);

        $this->createIndex('idx-interview-status', 'interview', 'status');
        $this->createIndex('idx-interview-employee_id', 'interview', 'employee_id');
      
        $this->addForeignKey('fk-interview-employee_id', 'interview', 'employee_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%interview}}');
    }
}
