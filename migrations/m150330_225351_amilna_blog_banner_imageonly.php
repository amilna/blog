<?php

use yii\db\Schema;
use yii\db\Migration;

class m150330_225351_amilna_blog_banner_imageonly extends Migration
{
    public function safeUp()
    {
		$this->addColumn( $this->db->tablePrefix.'blog_banner', 'image_only', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT FALSE' );
    }

    public function safeDown()
    {
        echo "m150330_225351_amilna_blog_banner_imageonly cannot be reverted.\n";

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
