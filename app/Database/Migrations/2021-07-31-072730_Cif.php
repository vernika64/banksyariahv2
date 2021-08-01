<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cif extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'uid'					=> [
				'type'				=> 'INT',
				'constraint'		=> 20,
				'auto_increment'	=> TRUE
			],
			'kode_id'				=> [
				'type'				=> 'BIGINT',
				'constraint'		=> 20,
			],
			'nama_cif'				=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 255
			],
			'tempat_l'				=> [
				'type'				=> 'CHAR',
				'constraint'		=> 50
			],
			'tgl_lhr_cif'				=> [
				'type'				=> 'DATE'
			],
			'jenis_k_cif'				=> [
				'type'				=> 'INT',
				'constraint'		=> 1
			],
			'wn_cif'				=> [
				'type'				=> 'INT',
				'constraint'		=> 1
			],
			'status_cif'				=> [
				'type'					=> 'INT',
				'constraint'			=> 1
			],
			'created_at'				=> [
				'type'					=>	'DATETIME'
			],
			'updated_at'				=> [
				'type'					=>	'DATETIME'
			],
			'deleted_at'				=> [
				'type'					=>	'DATETIME'
			],
		]);
		$this->forge->addKey('uid', true);
		$this->forge->addUniqueKey('kode_id');
		$this->forge->createTable('cif');
	}

	public function down()
	{
		//
	}
}
