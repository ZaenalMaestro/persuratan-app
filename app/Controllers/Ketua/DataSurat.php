<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class DataSurat extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratMasuk = new \App\Models\SuratMasuk();
		$this->suratKeluar = new \App\Models\SuratKeluar();
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		// menggabungkan semua surat masuk dan keluar
		$suratMasuk 	= $this->suratMasuk->findAll();
		$suratKeluar 	= $this->suratKeluar->findAll();
		$surat 			= array_merge($suratMasuk, $suratKeluar);

		// filter data surat hari ini
		$suratHariIni = array_filter($suratMasuk, function($data) {
			return ($data['penerima'] == session('nama') && $data['disposisi'] == 'disposisi');
		});

		// menampilkan data surat yang telah disposisi
		$disposisi = array_filter($suratMasuk, function($data) {
			return ($data['disposisi'] == 'disposisi');
		});

		$data = [
			'title' 					=> 'Data Surat',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'data_surat',
			'surat_hari_ini'		=> $suratHariIni,
			'penerima_surat'		=> $this->dataUser->findAll(),
			'validation'			=> $this->validation
		];

		return view('ketua/data_surat/index', $data);
	}
}