<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\CodeIgniter;
use CodeIgniter\Validation\Validation as ValidationValidation;
use Config\Validation;
use Exception;

class Cpanel extends BaseController

{
	// Field untuk memulai model
	protected $modulKaryawan;
	protected $modulInfoBank;
	protected $modulCif;
	protected $modulTabungan;
	protected $modulProdukTabungan;

	public function __construct()
	{
		$this->modulKaryawan = new \App\Models\Karyawan();
		$this->modulInfoBank = new \App\Models\Infobank();
		$this->modulCif = new \App\Models\Cif();
		$this->modulTabungan = new \App\Models\Tabungan();
		$this->modulProdukTabungan = new \App\Models\ProdukTabungan();
	}

	// Field untuk setup pertama kali
	public function setup()
	{
		return view('/Setup/index');
	}

	public function install()
	{
		$kd_bk = $this->request->getPost('kode_bk');
		$nm_bk = $this->request->getPost('nama_bk');
		$al_bk = $this->request->getPost('alamat_bk');

		$kd_kc = $this->request->getPost('kode_kc');
		$nm_kc = $this->request->getPost('nama_kc');
		$al_kc = $this->request->getPost('alamat_kc');
		$np_kc = $this->request->getPost('np_kc');
		$em_kc = $this->request->getPost('email_kc');
		$ps_kc1 = $this->request->getPost('pass_kc1');

		$this->modulInfoBank->save([
			'kode_bank'		=> $kd_bk,
			'nama_bank'		=> $nm_bk,
			'alamat_bank'	=> $al_bk,
			'kode_manager'	=> $kd_kc
		]);

		$this->modulKaryawan->save([
			'nik'			=> $kd_kc,
			'nama'			=> $nm_kc,
			'alamat_ktp'	=> $al_kc,
			'no_telp'		=> $np_kc,
			'email'			=> $em_kc,
			'password'		=> $ps_kc1,
			'level'			=> 0,
			'kd_bank'		=> $kd_bk,
			'recruiter'		=> 123456789
		]);

		session()->setFlashdata('pesan', 'Data berhasil disimpan, silahkan login untuk memulai');
		return redirect()->to('/');
	}


	// Field untuk Sistem Login
	public function proses()
	{
		$username = $this->request->getPost('user');

		$pass = $this->request->getPost('pass');
		$ps = $this->modulKaryawan->where('nik', $username)->findAll();
		$psdb = $ps[0]['password'];
		if ($psdb != $pass) {
			session()->setFlashdata('error', 'Username atau password salah');
			return redirect()->to('/');
		} else {
			session()->set([
				'sudah'	=> TRUE,
				'kode'	=> $ps[0]['nik'],
				'nama'	=> $ps[0]['nama'],
				'level'	=> $ps[0]['level'],
				'kd_bank'	=> $ps[0]['kd_bank']
			]);
			return redirect()->to('dashboard');
		}
	}

	public function index()
	{
		return view('index');
	}
	public function dashboard()
	{
		$data = [
			'judul'	=> 'Dashboard',
			'welcomemessage'	=> 'Selamat Datang'
		];

		return view('dashboard', $data);
	}

	// Modul Teller

	public function tariktunai()
	{
		$data = [
			'judul'	=> 'Tarik Tunai'
		];

		return view('Teller/tariktunai', $data);
	}

	public function setortunai()
	{
		$data = [
			'judul'		=> 'Setor Tunai'
		];

		return view('Teller/setortunai', $data);
	}

	public function transfer()
	{
		$data = [
			'judul'		=> 'Transfer Uang'
		];

		return view('Teller/transfer', $data);
	}

	// Modul Customer Service

	// Sub Modul CS - CIF

	public function buatcif()
	{
		session();
		$limiter = 5;
		$hal = $this->request->getGet('page_cif');
		if ($hal > 1) {
			$no = 1 + ($limiter * $hal) - 5;
		} else {
			$no = 1;
		}
		$datacif = $this->modulCif->paginate($limiter, 'cif');
		$halaman = $this->modulCif->pager;
		$data = [
			'judul'			=> 'Customer Identification file',
			'listcif'		=> $datacif,
			'hal'			=> $halaman,
			'no'			=> $no,
			'validation'	=> \Config\Services::validation()
		];
		return view('CS/cif', $data);
	}

	public function daftarcif()
	{
		if (!$this->validate([
			'kode'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Kode Identitas harus diisi',
					'is_unique'	=>	'Identitas sudah terdaftar'
				]
			],
			'nama'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Nama harus diisi',
				]
			],
			'tl'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Tempat lahir harus diisi',
				]
			],
			'tr'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Tanggal Lahir harus diisi',
				]
			],
			'alamat_s'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Alamat harus diisi',
				]
			],
			'jk'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Jenis Kelamin harus diisi',
				]
			],
			'wn'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Kewarganegaraan harus diisi',
				]
			],
			'sn'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'Status Pernikahan harus diisi',
				]
			],

		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('regcif')->withInput()->with('validation', $validation);
		}

		$CIF_kd = $this->request->getPost('kode');
		$CIF_nm = $this->request->getPost('nama');
		$CIF_tl = $this->request->getPost('tl');
		$CIF_al = $this->request->getPost('alamat_s');
		$CIF_tr = $this->request->getPost('tr');
		$CIF_jk = $this->request->getPost('jk');
		$CIF_wn = $this->request->getPost('wn');
		$CIF_sn = $this->request->getPost('sn');

		$cek = $this->modulCif->where('kode_id', $CIF_kd);
		if ($cek != NULL) {
			$this->modulCif->save([
				'kode_id'			=> $CIF_kd,
				'nama_cif'			=> $CIF_nm,
				'tempat_l'			=> $CIF_tl,
				'tgl_lhr_cif'		=> $CIF_tr,
				'alamat_cif'		=> $CIF_al,
				'jenis_k_cif'		=> $CIF_jk,
				'wn_cif'			=> $CIF_wn,
				'status_cif'		=> $CIF_sn
			]);
			session()->setFlashdata('pesan', 'CIF Berhasil disimpan');
			return redirect()->to('regcif');
		} else {
			session()->setFlashdata('error', 'Sistem mengalami error! Silahkan hubungi Administrator ASAP!');
			return redirect()->to('regcif');
		}
	}

	// Sub Modul CS - Rekening Nasabah

	public function regrek()
	{
		$limiter = 5;
		$hal = $this->request->getGet('page_cif');
		if ($hal > 1) {
			$no = 1 + ($limiter * $hal) - 5;
		} else {
			$no = 1;
		}
		$cari = $this->request->getPost('tipe');
		$cari_isi = $this->request->getPost('kd_cari');

		if ($cari != NULL) {
			switch ($cari) {
				case 1:
					$listn = $this->modulCif->where('kode_id', $cari_isi)->paginate(5, 'cif');
					break;
				case 2:
					$listn = $this->modulCif->where('nama_cif', $cari_isi)->paginate(5, 'cif');
					break;
				default:
					$listn = $this->modulCif->paginate(5, 'cif');
					session()->setFlashdata('error', 'Data tidak ditemukan');
			}
		} else {
			$listn = $this->modulCif->paginate(5, 'cif');
		}
		$paginate = $this->modulCif->pager;
		$ltab = $this->modulProdukTabungan->findAll();

		if ($listn == NULL) {
			session()->setFlashdata('error', 'Data tidak ditemukan');
		}

		$data = [
			'judul'		=> "Form Registrasi Rekening Wadiah",
			'nasabah'	=> $listn,
			'tab'		=> $ltab,
			'no'		=> $no,
			'hal'		=> $paginate,
			'validation'	=> \Config\Services::validation()
		];

		return view('CS/rek_buat', $data);
	}
	public function buattab()
	{
		if (!$this->validate([
			'urut'	=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nomor Antrian Nasabah harus diisi'
				]
			],
			'tabungan'	=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nomor Antrian Nasabah harus diisi'
				]
			],
			'TOS'	=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nomor Antrian Nasabah harus diisi'
				]
			],
			'SK'	=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nomor Antrian Nasabah harus diisi'
				]
			]
		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('registrasirek')->withInput()->with('validation', $validation);
		}

		$nk = $this->request->getPost('kode');
		$ur = $this->request->getPost('urut');
		$tb = $this->request->getPost('tabungan');

		// Plan untuk kedepan bila menggunakan TOS dan SK
		// $ts = $this->request->getPost('TOS');
		// $sk = $this->request->getPost('SK');


		$sp = "00";
		$bk = session()->get('kd_bank');

		$c1 = mt_rand(1000, 9999);

		$nrk = $bk . $sp . $tb . $c1 . $ur;

		$filter = $this->modulCif->where('kode_id', $nk)->first();
		if ($filter != null) {
			$this->modulTabungan->save([
				'norek'		=> $nrk,
				'nas_uid'	=> $nk,
				'kd_bank'	=> $bk,
				'gol_tab'	=> $tb,
				'nominal'	=> 0,
				'status'	=> 1
			]);
			session()->setFlashdata('pesan', 'Tabungan berhasil ditambahkan!');
			return redirect()->to('registrasirek');
		} else {
			session()->setFlashdata('error', 'Tabungan gagal ditambahkan!');
			return redirect()->to('registrasirek');
		}
	}

	// Field untuk Supervisor

	public function karyawanz()
	{
		session();
		$limiter = 5;
		$hal = $this->request->getGet('page_karyawan');
		if ($hal > 1) {
			$no = 1 + ($limiter * $hal) - 5;
		} else {
			$no = 1;
		}
		$datakar = $this->modulKaryawan->paginate($limiter, 'karyawan');
		$halaman = $this->modulKaryawan->pager;

		$data = [
			'judul'			=> "Daftar Karyawan",
			'karya'			=> $datakar,
			'hal'			=> $halaman,
			'no'			=> $no,
			'validation'	=> \Config\Services::validation()
		];

		return view('Supervisor/karyawan', $data);
	}

	public function buatKaryawan()
	{
		if (!$this->validate([
			'kode'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi',
					'is_unique'	=>	'{field} NIK sudah terdaftar'
				]
			],
			'nama'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi'
				]
			],
			'alamat'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi'
				]
			],
			'ponsel'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi'
				]
			],
			'email'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi'
				]
			],
			'jabatan'	=>	[
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=>	'{field} harus diisi'
				]
			]
		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('karyawan')->withInput()->with('validation', $validation);
		}

		$ps1 = $this->request->getPost('pass');
		$ps2 = $this->request->getPost('pass2');

		if ($ps1 != $ps2) {
			session()->setFlashdata('error', 'Error, Password tidak sama');
			return redirect()->to('karyawan');
		} else {
			$kd = $this->request->getPost('kode');
			$nm = $this->request->getPost('nama');
			$al = $this->request->getPost('alamat');
			$pn = $this->request->getPost('ponsel');
			$em = $this->request->getPost('email');
			$jb = $this->request->getPost('jabatan');

			$this->modulKaryawan->insert([
				'nik'	=> $kd,
				'nama'	=> $nm,
				'alamat_ktp'	=> $al,
				'no_telp'	=> $pn,
				'email'	=> $em,
				'password'	=> $ps1,
				'level'	=> $jb,
			]);

			session()->setFlashdata('pesan', 'Karyawan berhasil ditambahkan!');
			return redirect()->to('karyawan');
		}
	}
}
