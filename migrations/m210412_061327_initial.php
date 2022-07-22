<?php

use yii\db\Migration;

/**
 * Class m210412_061327_initial
 */
class m210412_061327_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/sql/init.sql');
        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210412_061327_initial cannot be reverted.\n";

        return true;
    }
}
