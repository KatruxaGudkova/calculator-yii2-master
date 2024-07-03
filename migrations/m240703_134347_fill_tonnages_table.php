<?php

use yii\db\Migration;

/**
 * Class m240703_134347_fill_tonnages_table
 */
class m240703_134347_fill_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            INSERT INTO tonnages (value) VALUES (25), (50), (75), (100)
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240703_134347_fill_tonnages_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240703_134347_fill_tonnages_table cannot be reverted.\n";

        return false;
    }
    */
}
