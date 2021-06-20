<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class SuratMasuk extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratMasuk = new \App\Models\SuratMasuk();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratMasuk->findAll();

		$data = [
			'title' 					=> 'Surat Masuk',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'surat_masuk',
			'surat_hari_ini'		=> $surat,
			'folder'					=> 'surat_masuk'
		];

		return view('ketua/surat_masuk/index', $data);
	}
}