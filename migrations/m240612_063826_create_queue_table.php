<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m240612_063826_create_queue_table extends Migration
{
  /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->bigPrimaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull(),
            'reserved_at' => $this->integer(),
            'attempt' => $this->integer(),
            'done_at' => $this->integer(),
        ]);

        $this->createIndex('idx-queue-channel', '{{%queue}}', 'channel');
        $this->createIndex('idx-queue-reserved_at', '{{%queue}}', 'reserved_at');
        $this->createIndex('idx-queue-done_at', '{{%queue}}', 'done_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
