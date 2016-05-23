<?php

use yii\db\Schema;
use yii\db\Migration;

class m150311_000744_amilna_blog_static extends Migration
{
    public function up()
    {
		$this->createTable($this->db->tablePrefix.'blog_static', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(65) NOT NULL',
            'description' => Schema::TYPE_STRING . '(155) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',            
            'tags' => Schema::TYPE_STRING . '',                       
            'status' => Schema::TYPE_SMALLINT. ' NOT NULL DEFAULT 1',
            'time' => Schema::TYPE_TIMESTAMP. ' NOT NULL DEFAULT NOW()',
            'isdel' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ]);
        
        $this->createTable($this->db->tablePrefix.'blog_files', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(65) NOT NULL',
            'description' => Schema::TYPE_STRING . '(155) NOT NULL',
            'file' => Schema::TYPE_TEXT . ' NOT NULL',            
            'tags' => Schema::TYPE_STRING . '',
            'status' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',            
            'time' => Schema::TYPE_TIMESTAMP. ' NOT NULL DEFAULT NOW()',
            'isdel' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ]);
    }

    public function down()
    {
        echo "m150311_000744_amilna_blog_static cannot be reverted.\n";

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
