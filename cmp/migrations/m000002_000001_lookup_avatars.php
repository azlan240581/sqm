<?php

use yii\db\Migration;

class m000002_000001_lookup_avatars extends Migration
{
	/*
    public function up()
    {
    }

    public function down()
    {
    }
	*/
	
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
		$this->createTable("lookup_avatars", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"image" => "varchar(255) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_avatars',array(
					  'id'=>'1',
					  'name'=>'Avatar 1',
					  'image'=>'/cmp/contents/avatar/avatar1.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'2',
					  'name'=>'Avatar 2',
					  'image'=>'/cmp/contents/avatar/avatar2.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'3',
					  'name'=>'Avatar 3',
					  'image'=>'/cmp/contents/avatar/avatar3.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'4',
					  'name'=>'Avatar 4',
					  'image'=>'/cmp/contents/avatar/avatar4.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'5',
					  'name'=>'Avatar 5',
					  'image'=>'/cmp/contents/avatar/avatar5.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'6',
					  'name'=>'Avatar 6',
					  'image'=>'/cmp/contents/avatar/Avatar6.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'7',
					  'name'=>'Avatar 7',
					  'image'=>'/cmp/contents/avatar/Avatar7.jpg',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'8',
					  'name'=>'Avatar 8',
					  'image'=>'/cmp/contents/avatar/Avatar8.png',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'9',
					  'name'=>'Avatar 9',
					  'image'=>'/cmp/contents/avatar/Avatar9.jpg',
					  ));

		$this->insert('lookup_avatars',array(
					  'id'=>'10',
					  'name'=>'Avatar 10',
					  'image'=>'/cmp/contents/avatar/Avatar10.jpg',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_avatars');
		$this->dropTable('lookup_avatars');
    }
}
