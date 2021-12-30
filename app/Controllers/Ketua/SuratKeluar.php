<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

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
		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=> $this->suratKeluar->where('status_komentar', 'diterima')->find(),
			'folder'					=> 'surat_keluar'
		];

		return view('ketua/surat_keluar/index', $data);
	}

	// print surat keluar
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratKeluar->where('status_komentar', 'diterima')->find(),
			'judul'	=> 'Laporan Surat Keluar'
		];
		return view('download/all_surat_keluar', $data);
	}

	public function download($id)
	{
		$data = [
			'surat_keluar' => $this->suratKeluar->where('id', $id)->first(),
		];

		return view('download/surat_keluar', $data);
	}

	public function lihat($id)
	{
		$data = [
			'surat_keluar' => $this->suratKeluar->where('id', $id)->first(),
		];

		return view('download/lihat_k', $data);
	}
}