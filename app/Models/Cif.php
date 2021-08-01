<?php

namespace App\Models;

use CodeIgniter\Model;

class Cif extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'cif';
	protected $primaryKey           = 'uid';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType 			= 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'kode_id',
		'nama_cif',
		'tempat_l',
		'tgl_lhr_cif',
		'alamat_cif',
		'jenis_k_cif',
		'wn_cif',
		'status_cif'
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// // Validation
	// protected $validationRules      = [];
	// protected $validationMessages   = [];
	// protected $skipValidation       = false;
	// protected $cleanValidationRules = true;

	// // Callbacks
	// protected $allowCallbacks       = true;
	// protected $beforeInsert         = [];
	// protected $afterInsert          = [];
	// protected $beforeUpdate         = [];
	// protected $afterUpdate          = [];
	// protected $beforeFind           = [];
	// protected $afterFind            = [];
	// protected $beforeDelete         = [];
	// protected $afterDelete          = [];
}
