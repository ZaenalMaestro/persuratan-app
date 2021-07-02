<?php
namespace App\Controllers\Kepala;
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

		// filter data surat hari ini
		$suratHariIni = array_filter($suratMasuk, function($data) {
			return ($data['penerima'] == session('nama') && $data['disposisi'] == 'disposisi');
		});

		$data = [
			'title' 					=> 'Data Surat',
			'role' 					=> 'Kepala',
			'active_link' 			=> 'data_surat',
			'surat_hari_ini'		=> $suratHariIni,
		];

		return view('kepala/data_surat/index', $data);
	}
}