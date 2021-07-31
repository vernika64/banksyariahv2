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
	public function __construct()
	{
		$this->modulKaryawan = new \App\Models\Karyawan();
		$this->modulInfoBank = new \App\Models\Infobank();
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
				'level'	=> $ps[0]['level']
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
	public function cif()
	{
		$data = [
			'judul'		=> 'Customer Identification file'
		];
		return view('cif', $data);
	}

	// Field untuk Karyawan

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

		return view('karyawan', $data);
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




	// Field Untuk Supervisor

	// Field untuk Customer Service

	// Field untuk Teller

	// Field untuk Back Office

}
