<?php

use yii\db\Migration;

/**
 * Handles the creation for table `search_history`.
 */
class m160923_121236_create_search_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('search_history', [
            'id' => $this->primaryKey(),
            'md5text' => $this->string(32)->notNull(),
            'fulltext' => $this->string(256)->notNull(),
            'time' => $this->dateTime()->defaultExpression('NOW()'),
            'byquery' => $this->string(128)->notNull(),
            'details' => $this->text()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('search_history');
    }
}
