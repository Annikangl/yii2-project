<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dismiss}}`.
 */
class m220705_175550_create_dismiss_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dismiss}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'employee_id' => $this->integer(),
        ]);

        $this->createIndex('idx-dismiss-order_id', 'dismiss', 'order_id');
        $this->createIndex('idx-dismiss-employee_id', 'dismiss', 'employee_id');

        $this->addForeignKey('fk_dismiss_order_id', 'dismiss', 'order_id', 'order', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_dismiss_employee_id', 'dismiss', 'employee_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dismiss}}');
    }
}
