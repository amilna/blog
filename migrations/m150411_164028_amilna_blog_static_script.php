<?php

use yii\db\Schema;
use yii\db\Migration;

class m150411_164028_amilna_blog_static_script extends Migration
{
    public function safeUp()
    {
		$this->addColumn( $this->db->tablePrefix.'blog_static', 'scripts', Schema::TYPE_TEXT . '' );
    }

    public function safeDown()
    {
        echo "m150411_164028_amilna_blog_static_script cannot be reverted.\n";

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
