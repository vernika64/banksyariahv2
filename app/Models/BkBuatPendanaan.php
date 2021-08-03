<?php

namespace App\Models;

use CodeIgniter\Model;

class BkBuatPendanaan extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'bk_pendanaan';
	protected $primaryKey           = 'uid';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'no_nota',
		'kd_cif',
		'jenis',
		'barang',
		'qty',
		'satuan',
		'status',
		'alasan',
		'pembayaran',
		'cs_id',
		'bo_id',
		'angsuran',
		'sum_angsuran',
		'frek_angsuran',
		'surplus_kontrak',
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
}
