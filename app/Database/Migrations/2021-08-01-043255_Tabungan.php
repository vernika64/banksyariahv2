<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tabungan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'tab_uid'			=> [
				'type'				=> 'INT',
				'constraint'		=> 20,
				'auto_increment'	=> TRUE
			],
			'nas_uid'				=> [
				'type'				=> 'INT',
				'constraint'		=> 20
			],
			'gol_tab'				=> [
				'type'				=> 'CHAR',
				'constraint'		=> 10
			],
			'nominal'				=> [
				'type'				=> 'BIGINT'
			],
			'status'				=> [
				'type'				=> 'INT',
				'constraint'		=> 1
			],
			'created_at'			=> [
				'type'				=> 'DATETIME'
			],
			'updated_at'			=> [
				'type'				=> 'DATETIME'
			],
			'deleted_at'			=> [
				'type'				=> 'DATETIME'
			]
		]);
		$this->forge->addKey('tab_uid', true);
		$this->forge->createTable('tabungan');
	}

	public function down()
	{
		//
	}
}
