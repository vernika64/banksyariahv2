<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Infobank extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'kode_bank'			=> [
				'type'			=> 'INT',
				'constraint'	=> 3
			],
			'tipe_bank'			=> [
				'type'			=> 'INT',
				'constraint'	=> 1
			],
			'nama_bank'			=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100
			],
			'alamat_bank'		=> [
				'type'			=> 'TEXT',
			],
			'kode_manager'		=> [
				'type'			=> 'CHAR',
				'constraint'	=> 20
			],
			'created_at'		=> [
				'type'			=> 'DATETIME'
			],
			'updated_at'		=> [
				'type'			=> 'DATETIME'
			],
			'deleted_at'		=> [
				'type'			=> 'DATETIME'
			]
		]);

		$this->forge->addKey('kode_bank', true);
		$this->forge->addKey('kode_manager');
		$this->forge->createTable('infobank');
	}

	public function down()
	{
		//
	}
}
