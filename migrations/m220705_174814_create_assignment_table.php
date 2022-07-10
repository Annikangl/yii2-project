<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assignment}}`.
 */
class m220705_174814_create_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assignment}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'employee_id' => $this->integer(),
            'position_id' => $this->integer(),
            'date' => $this->date(),
            'rate'=> $this->integer(),
            'salary' => $this->integer(),
            'status' => $this->smallInteger()->notNull()
        ]);

        $this->createIndex('idx-assignment-order_id', 'assignment', 'order_id');
        $this->createIndex('idx-assignment-employee_id', 'assignment', 'employee_id');
        $this->createIndex('idx-assignment-position_id', 'assignment', 'position_id');
        $this->createIndex('idx-assignment-status', 'assignment', 'status');

        $this->addForeignKey('fk_assignment_order_id', 'assignment', 'order_id', 'order', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_assignment_employee_id', 'assignment', 'employee_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_assignment_position_id', 'assignment', 'position_id', 'position', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%assignment}}');
    }
}
