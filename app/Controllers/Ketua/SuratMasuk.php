<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratMasuk extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratMasuk = new \App\Models\SuratMasuk();
		
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
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

	public function lihat()
	{
		$segmant = $this->request->uri->getSegments();
		$nomor_surat = "$segmant[3]/$segmant[4]/$segmant[5]/$segmant[6]";
		$surat = $this->suratMasuk->where('nomor_surat', $nomor_surat)->first();
		$data = [
			'title' 					=> 'Lihat Surat',
			'role' 					=> 'Admin',
			'active_link' 			=> 'surat_masuk',
			'surat_masuk'			=> $surat,
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('pdf_view', $data);
	}

	// print surat masuk
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratMasuk->findAll(),
			'judul'	=> 'Laporan Surat Masuk'
		];
		return view('download/all_surat_masuk', $data);
	}
}