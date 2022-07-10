<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract}}`.
 */
class m220705_173441_create_contract_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'date_open' => $this->date()->notNull(),
            'date_close' => $this->date(),
            'close_reason' => $this->text(),
        ]);

        $this->createIndex('idx-contract-employee_id', 'contract', 'employee_id');

        $this->addForeignKey('fk_contract_employee_id', 'contract', 'employee_id', 'employee', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contract}}');
    }
}
