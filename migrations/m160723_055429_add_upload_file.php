<?php

use yii\db\Migration;

class m160723_055429_add_upload_file extends Migration
{
    public function up()
    {
$this->execute('CREATE TABLE `uploaded_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `added_by` int(11) NOT NULL,
  `candidate_first_name` varchar(100) NOT NULL,
  `candidate_last_name` varchar(100) DEFAULT NULL,
  `file_name` varchar(500) DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
)');
    }

    public function down()
    {
        echo "m160723_055429_add_upload_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
