<?php

use yii\db\Migration;

/**
 * Class m240703_134324_fill_months_table
 */
class m240703_134324_fill_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        INSERT INTO months (name) VALUES
            ('январь'), ('февраль'), ('март'), ('апрель'), ('май'), ('июнь'),
            ('июль'), ('август'), ('сентябрь'), ('октябрь'), ('ноябрь'), ('декабрь')
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240703_134324_fill_months_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240703_134324_fill_months_table cannot be reverted.\n";

        return false;
    }
    */
}
