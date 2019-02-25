<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log_transactions}}`.
 */
class m190224_080446_create_log_transactions_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable(
            '{{%log_transactions}}',
            [
                'id'           => $this->primaryKey(),
                'data'         => $this->dateTime()->notNull(),
                'from_user_id' => $this->integer()->notNull(),
                'to_user_id'   => $this->integer()->notNull(),
                'sum'          => $this->decimal()->notNull(),
                'transferred'  => $this->boolean()->defaultValue(false),
            ]
        );
        
        $this->addForeignKey(
            'from_u',
            'log_transactions',
            'from_user_id',
            'user',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'to_u',
            'log_transactions',
            'to_user_id',
            'user',
            'id',
            'CASCADE'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%log_transactions}}');
        $this->dropForeignKey(
            'from_u',
            'user'
        );
        $this->dropForeignKey(
            'to_u',
            'user'
        );
    }
}
