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
	protected $modulBkTransfer;
	protected $modulBkTarikTunai;
	protected $modulBkBuatTabungan;
	protected $modulBkBuatPendanaan;

	public function __construct()
	{
		$this->modulKaryawan = new \App\Models\Karyawan();
		$this->modulInfoBank = new \App\Models\Infobank();
		$this->modulCif = new \App\Models\Cif();
		$this->modulTabungan = new \App\Models\Tabungan();
		$this->modulProdukTabungan = new \App\Models\ProdukTabungan();
		$this->modulBkTransfer = new \App\Models\BkTransfer();
		$this->modulBkTarikTunai = new \App\Models\BkTarikTunai();
		$this->modulBkBuatTabungan = new \App\Models\BkBuatTabungan();
		$this->modulBkBuatPendanaan = new \App\Models\BkBuatPendanaan();
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
		$no = 1;
		$kd_cari = $this->request->getPost('kd_cari');
		$db = \Config\Database::connect();
		$query = $db->query("SELECT tabungan.tab_uid, tabungan.norek, cif.nama_cif, produk_tabungan.nama_produk, tabungan.status FROM tabungan LEFT JOIN cif ON tabungan.nas_uid = cif.kode_id LEFT JOIN produk_tabungan ON tabungan.gol_tab = produk_tabungan.kode_tabungan WHERE tabungan.norek = '$kd_cari AND tabungan.status = 1'");
		$list = $query->getResult('array');

		if (count($list) == NULL && $kd_cari != NULL) {
			session()->setFlashdata('error', 'Tabungan tidak ditemukan');
		}
		$data = [
			'judul'	=> 'Tarik Tunai',
			'tabungan'	=> $list,
			'no'		=> $no
		];

		return view('Teller/tariktunai', $data);
	}

	public function prosestt()
	{
		session();
		if (!$this->validate([
			'kode'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nominal Tarik Tunai harus diisi'
				]
			],
			'jmltarik'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nominal Tarik Tunai harus diisi'
				]
			]
		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('tt')->withInput()->with('validation', $validation);
		}

		$kd = $this->request->getPost('kode');
		$nm = $this->request->getPost('jmltarik');

		$cek = $this->modulTabungan->where('tab_uid', $kd)->first();
		if ($cek != NULL) {
			$value = $this->modulTabungan->where('tab_uid', $kd)->findAll();
			if ($value[0]['status'] == 2 || $value[0]['deleted_at'] != NULL) {
				session()->setFlashdata('error', 'Tabungan sudah tidak berlaku!');
				return redirect()->to('tt');
			} else if ($value[0]['status'] == 0 || $value[0]['status'] == 3) {
				session()->setFlashdata('error', 'Tabungan masih belum aktif!');
				return redirect()->to('tt');
			}

			$nominal = $value[0]['nominal'];
			if ($nominal <= 50000) {
				session()->setFlashdata('error', 'Jumlah penarikan melebihi batas minimal saldo tabungan');
				return redirect()->to('tt');
			} else {
				$kdbank = session()->get('kd_bank');
				$kdkar = session()->get('kode');

				$calc = $nominal - $nm;

				// KDBANK/TIPE_TRANSAKSI/LASTID/THN
				$lastid = $this->modulBkTarikTunai->first();
				if ($lastid == NULL) {
					$nota = $kdbank . "/TRK/1" . date("Y");
				} else {
					$db = \Config\Database::connect();
					$query = $db->query("SELECT uid FROM bk_tariktunai ORDER BY uid DESC LIMIT 1");
					$ls = $query->getResult('array');
					$notaakhir = $ls[0]['uid'] + 1;
					$nota = $kdbank . "/TRK/" . $notaakhir . date("Y");
				}

				$this->modulBkTarikTunai->save([
					'no_nota'				=> $nota,
					'no_rek'				=> $value[0]['norek'],
					'nominal'				=> $nm,
					'saldo_akhir'			=> $calc,
					'kd_karyawan'			=> $kdkar
				]);

				$this->modulTabungan->update($kd, ['nominal' => $calc]);
				session()->setFlashdata('pesan', 'Tabungan berhasil ditarik');
				return redirect()->to('tt');
			}
		} else {
			session()->setFlashdata('error', 'Tabungan tidak terdaftar!');
			return redirect()->to('tt');
		}
	}

	public function transfer()
	{

		$rek_to = $this->request->getPost('norek');
		$rek_nm = $this->request->getPost('an');
		$num = $this->request->getPost('nominal');
		$tunai = $this->request->getPost('tunai');
		$saving = $this->request->getPost('tab');
		$tbl_tn = $this->request->getPost('btntun');
		$tbl_tb = $this->request->getPost('btntab');
		$kd_bank = session()->get('kd_bank');
		$kd_kar = session()->get('kode');

		$db = \Config\Database::connect();
		$builder = $db->query("SELECT uid FROM bk_transfer ORDER BY uid DESC LIMIT 1");
		$last = $builder->getResult('array');


		if ($last == NULL) {

			// KDBANK/TIPE_TRANSAKSI/LASTID/THN
			$nolast = 1;
			$no_nota = $kd_bank . "/TRF/" . $nolast . "/" . date("Y");

			if ($tbl_tn != NULL) {
				$this->modulBkTransfer->save([
					'no_nota'			=> $no_nota,
					'no_rek_tujuan'		=> $rek_to,
					'atasnama'			=> $rek_nm,
					'num_transfer'		=> $num,
					'jenis'				=> "TRF",
					'nama_pengirim'		=> $tunai,
					'kd_karyawan'		=> $kd_kar
				]);
				session()->setFlashdata('pesan', 'Data berhasil disimpan');
			} else if ($tbl_tb != NULL) {
				$nama_nas_tab = $db->query("SELECT cif.nama_cif FROM cif LEFT JOIN tabungan ON cif.kode_id = tabungan.nas_uid WHERE tabungan.norek = '$saving'");
				$namanastab = $nama_nas_tab->getResult('array');
				if ($namanastab != NULL) {
					$this->modulBkTransfer->save([
						'no_nota'			=> $no_nota,
						'no_rek_tujuan'		=> $rek_to,
						'atasnama'			=> $rek_nm,
						'num_transfer'		=> $num,
						'jenis'				=> "TRF",
						'nama_pengirim'		=> $namanastab[0]['nama_cif'],
						'no_rek_pengirim'	=> $saving,
						'kd_karyawan'		=> $kd_kar
					]);
					session()->setFlashdata('pesan', 'Data berhasil disimpan');
				} else {
					session()->setFlashdata('error', 'Rekening Tabungan belum terdaftar');
				}
			}
		} else {
			$nolast = $last[0]['uid'] + 1;
			$no_nota = $kd_bank . "/TRF/" . $nolast . "/" . date("Y");

			if ($tbl_tn != NULL) {
				$this->modulBkTransfer->save([
					'no_nota'			=> $no_nota,
					'no_rek_tujuan'		=> $rek_to,
					'atasnama'			=> $rek_nm,
					'num_transfer'		=> $num,
					'jenis'				=> "TRF",
					'nama_pengirim'		=> $tunai,
					'kd_karyawan'		=> $kd_kar
				]);
				session()->setFlashdata('pesan', 'Data berhasil disimpan');
			} else if ($tbl_tb != NULL) {
				$nama_nas_tab = $db->query("SELECT cif.nama_cif FROM cif LEFT JOIN tabungan ON cif.kode_id = tabungan.nas_uid WHERE tabungan.norek = $saving");
				$namanastab = $nama_nas_tab->getResult('array');
				if ($namanastab != NULL) {
					$this->modulBkTransfer->save([
						'no_nota'			=> $no_nota,
						'no_rek_tujuan'		=> $rek_to,
						'atasnama'			=> $rek_nm,
						'num_transfer'		=> $num,
						'jenis'				=> "TRF",
						'nama_pengirim'		=> $namanastab[0]['nama_cif'],
						'no_rek_pengirim'	=> $saving,
						'kd_karyawan'		=> $kd_kar

					]);
					session()->setFlashdata('pesan', 'Data berhasil disimpan');
				} else {
					session()->setFlashdata('error', 'Rekening Tabungan belum terdaftar');
				}
			}
		}

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
		$kk = session()->get('kode');

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
				'status'	=> 0,
				'cs_id'		=> $kk
			]);

			$this->modulBkBuatTabungan->save([
				'no_rek' 		=> $nrk,
				'nas_uid'		=> $nk,
				'gol_tab'		=> $tb,
				'kd_karyawan'	=> $kk,
				'aksi'			=> "Buat Tabungan Baru"
			]);

			session()->setFlashdata('pesan', 'Tabungan berhasil ditambahkan, mohon tunggu konfirmasi dari Back Office');
			return redirect()->to('registrasirek');
		} else {
			session()->setFlashdata('error', 'CIF tidak terdaftar!');
			return redirect()->to('registrasirek');
		}
	}

	public function tutuprek()
	{
		$data = [
			'judul'				=> "Tutup buku"
		];
		return view('CS/rek_tutup', $data);
	}

	// Sub Modul Peminjaman Mudharabah

	public function formpeminjamanuang()
	{
		$listcif = $this->modulCif->findAll();

		$data = [
			'judul'			=> "Peminjaman Mudharabah",
			'listcif'		=> $listcif
		];

		return view('CS/forminvestasi', $data);
	}
	public function propeminjamuang()
	{
		if (!$this->validate([
			'tipepeminjam' => [
				'rules'	=> 'required',
				'errors'	=> [
					'required'	=> 'Jenis Peminjam harus diisi'
				]
			],
			'cif'	=> [
				'rules'	=> 'required',
				'errors'	=> [
					'required'	=> 'Data CIF harus dipilih'
				]
			],
			'nominal'	=> [
				'rules'	=> 'required|integer|is_natural_no_zero',
				'errors'	=> [
					'required'	=> 'Jumlah nominal harus diisi',
					'integer'	=> 'Data harus diisi dengan angka',
					'is_natural_no_zero'	=> 'Nominal tidak boleh 0 atau negatif'
				]
			],
			'alasan'	=> [
				'rules'	=> 'required',
				'errors'	=> [
					'required'	=> 'Alasan peminjaman harus diisi'
				]
			]
		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('formpeminjaman')->withInput()->with('validation', $validation);
		}

		$d1 = $this->request->getPost('tipepeminjam');
		$d2 = $this->request->getPost('cif');
		$d3 = $this->request->getPost('nominal');
		$d4 = $this->request->getPost('alasan');
		$d5 = $this->request->getPost('dokumen');
	}


	// Sub Modul Pendanaan Murabahah

	public function formpendanaan()
	{
		$tombol = $this->request->getPost('tombol');

		$db = \Config\Database::connect();
		$list = $this->modulCif->findAll();
		$data = [
			'judul'		=> 'Pendanaan akad Murabahah',
			'list'		=> $list
		];

		return view('CS/formpendanaan', $data);
	}

	public function propendanaan()
	{
		if (!$this->validate([
			'nasabah'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Kolom nasabah harus dipilih'
				]
			],
			'jenis'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Jenis pendanaan harus diisi'
				]
			],
			'barang'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Nama barang harus diisi'
				]
			],
			'qty'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Jumlah barang harus diisi'
				]
			],
			'alasan'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Alasan pendanaan harus diisi'
				]
			],
			'tipem'		=> [
				'rules'		=> 'required',
				'errors'	=> [
					'required'	=> 'Metode Pembayaran harus dipilih salah satu'
				]
			],

		])) {
		}
		$kdbank = session()->get('kd_bank');
		$nasabah = $this->request->getPost('nasabah');
		$jenis = $this->request->getPost('jenis');
		$barang = $this->request->getPost('barang');
		$qty = $this->request->getPost('qty');
		$harga = $this->request->getPost('harga');
		$alasan = $this->request->getPost('alasan');
		$tipem = $this->request->getPost('tipem');
		$cs = session()->get('kode');

		// Untuk selanjutnya bila memakai file untuk pendukung pendanaan
		// $pendukung = $this->request->getPost('pendukung');
		// $sk = $this->request->getPost('sk');

		try {
			$cek = $this->modulBkBuatPendanaan->first();
			if ($cek == NULL) {
				$no_nota = $kdbank . "/TRK/1" . date("Y");
			} else {
				$db = \Config\Database::connect();
				$q = $db->query('SELECT uid FROM bk_pendanaan ORDER BY uid DESC LIMIT 1');
				$s = $q->getResult('array');
				$ww = $s[0]['uid'] + 1;
				$no_nota = $kdbank . "/TRK/" . $ww . date("Y");
			}
			$this->modulBkBuatPendanaan->save([
				'no_nota'			=> $no_nota,
				'kd_cif'			=> $nasabah,
				'jenis'				=> $jenis,
				'barang'			=> $barang,
				'qty'				=> $qty,
				'satuan'			=> $harga,
				'alasan'			=> $alasan,
				'pembayaran'		=> $tipem,
				'cs_id'				=> $cs
			]);

			session()->setFlashdata('pesan', 'Permintaan berhasil diajukan, tunggu konfirmasi dari Back Office!');
			return redirect()->to('formpendanaan');
		} catch (Exception $e) {
			session()->setFlashdata('error', 'Terjadi kesalahan di dalam aplikasi, segera hubungi Administrator!' . $e);
			return redirect()->to('formpendanaan');
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

	// Sub Modul Cek Transaksi Setor Tunai
	public function cekbktransfer()
	{
		$limiter = 5;
		$hal = $this->request->getGet('page_karyawan');
		if ($hal > 1) {
			$no = 1 + ($limiter * $hal) - 5;
		} else {
			$no = 1;
		}
		$tabel = $this->modulBkTransfer->paginate($limiter, 'bk_transfer');
		$pager = $this->modulBkTransfer->pager;

		$data = [
			'judul'				=> 'Data Transaksi Setor Tunai',
			'bk_transfer'		=> $tabel,
			'pager'				=> $pager,
			'no'				=> $no
		];

		return view('Supervisor/bk_setor', $data);
	}

	// Modul Back Office

	public function veriftab()
	{

		$no = 1;

		$db = \Config\Database::connect();
		$query = $db->query("SELECT tabungan.tab_uid, tabungan.gol_tab, tabungan.norek, tabungan.status, cif.nama_cif, produk_tabungan.nama_produk FROM tabungan LEFT JOIN cif ON tabungan.nas_uid = cif.kode_id LEFT JOIN produk_tabungan ON tabungan.gol_tab = produk_tabungan.kode_tabungan WHERE tabungan.status = 0");
		$tabungan = $query->getResult('array');

		$data = [
			'judul'		=> 'Verifikasi Data Tabungan',
			'tabungan'	=> $tabungan,
			'no'		=> $no,
		];

		return view('BO/verifikasitabungan', $data);
	}

	public function proveriftabok()
	{
		$tombol = $this->request->getPost('kirim');
		$kode = $this->request->getPost('kode');

		try {
			switch ($tombol) {
				case "Terima":
					$this->modulTabungan->update($kode, ['status' => 1]);
					session()->setFlashdata('pesan', 'Tabungan berhasil diaktifkan');
					break;
				case "Tolak":
					$this->modulTabungan->update($kode, ['status' => 3]);
					session()->setFlashdata('pesan', 'Tabungan berhasil ditolak');
					break;
				default:
					session()->setFlashdata('pesan', 'Terjadi error di sistem, silahkan menghubungi Administrator!');
			}

			return redirect()->to('verifikasitabungan');
		} catch (Exception $e) {
			session()->setFlashdata('error', $e);
			return redirect()->to('verifikasitabungan');
		}
	}

	public function verifpendanaan()
	{
		$no = 1;
		$db = \Config\Database::connect();
		$q = $db->query('SELECT cif.nama_cif, cif.kode_id, cif.alamat_cif,bk_pendanaan.uid, bk_pendanaan.pembayaran, bk_pendanaan.alasan, bk_pendanaan.status, bk_pendanaan.no_nota, bk_pendanaan.jenis, bk_pendanaan.barang, bk_pendanaan.qty, bk_pendanaan.satuan FROM bk_pendanaan LEFT JOIN cif ON bk_pendanaan.kd_cif = cif.kode_id');
		$r = $q->getResult('array');

		$data = [
			'judul'	=> 'List Pendanaan yang butuh diverifikasi',
			'list'	=> $r,
			'no'	=> $no
		];

		return view('BO/verifikasipendanaan', $data);
	}

	public function proverifpenda()
	{
		$nota = $this->request->getPost('nota');
		$btn = $this->request->getPost('lanjut');


		if ($btn == "Verifikasi") {
			$s = 1;
		} else if ($btn == "Tolak") {
			$s = 4;
		}

		try {
			$this->modulBkBuatPendanaan->update($nota, ['status' => $s]);
			session()->setFlashdata('pesan', 'Pendanaan berhasil diverifikasi');
			return redirect()->to('verifikasipendanaan');
		} catch (Exception $e) {
			session()->setFlashdata('error', 'Teradi error di dalam sistem, silahkan menghubungi Administrator!');
			return redirect()->to('verifikasipendanaan');
		}
	}
}
