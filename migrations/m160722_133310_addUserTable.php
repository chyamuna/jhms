<?php

use yii\db\Migration;

class m160722_133310_addUserTable extends Migration
{
    public function up()
    {
	$this->execute('CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `access_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
)'); 
    }

    public function down()
    {
        echo "m160722_133310_addUserTable cannot be reverted.\n";

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
