<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class SuratKeluar extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratKeluar = new \App\Models\SuratKeluar();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratKeluar->findAll();
		// filter data surat sekertaris

		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=> $surat,
			'folder'					=> 'surat_keluar'
		];

		return view('ketua/surat_keluar/index', $data);
	}
}