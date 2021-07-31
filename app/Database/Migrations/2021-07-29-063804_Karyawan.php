<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'uid'	=> [
				'type'				=> 'INT',
				'constraint'		=> 20,
				'auto_increment'	=> TRUE
			],
			'nik'	=> [
				'type'			=> 'INT',
				'constraint'	=> 20
			],
			'nama'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100
			],
			'alamat_ktp'	=> [
				'type'			=> 'TEXT'
			],
			'no_telp'	=> [
				'type'			=> 'CHAR',
				'constraint'	=> 15
			],
			'email'		=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100
			],
			'password'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 255
			],
			'level'		=> [
				'type'			=> 'INT',
				'constraint'	=> 1
			],
			'kd_bank'		=> [
				'type'			=> 'INT',
				'constraint'	=> 3
			],
			'recruiter'		=> [
				'type'			=> 'INT',
				'constraint'	=> 20
			],
			'created_at'		=> [
				'type'			=> 'DATETIME'
			],
			'updated_at'		=> [
				'type'			=> 'DATETIME'
			],
			'deleted_at'		=> [
				'type'			=> 'DATETIME',
				'NULL'			=> TRUE
			]
		]);
		$this->forge->addKey('uid', true);
		$this->forge->addUniqueKey('nik');
		$this->forge->createTable('karyawan');
	}

	public function down()
	{
		//
	}
}
