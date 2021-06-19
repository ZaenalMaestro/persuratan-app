<?php
namespace App\Controllers\Kepala;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class Dashboard extends BaseController
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
		$suratHariIni = array_filter($surat, function($data) {
			return ($data['tanggal'] == date('Y-m-d') && $data['penerima'] == session('nama') && $data['disposisi'] == 'disposisi');
		});

		// menampilkan data surat yang telah disposisi
		$disposisi = array_filter($surat, function($data) {
			return ($data['disposisi'] == 'disposisi');
		});

		$data = [
			'title' 					=> 'Dashboard',
			'role' 					=> 'Kepala',
			'active_link' 			=> 'dashboard',
			'surat_hari_ini'		=> $suratHariIni,
			'total_surat_masuk'	=> count($suratMasuk),
			'total_surat_keluar'	=> count($suratKeluar),
			'total_disposisi'		=> count($disposisi),
			'penerima_surat'		=> $this->dataUser->findAll(),
			'validation'			=> $this->validation
		];

		return view('ketua/dashboard/index', $data);
	}

	public function show()
	{
		$segmant = $this->request->uri->getSegments();
		$nomor_surat = "$segmant[2]/$segmant[3]/$segmant[4]/$segmant[5]";
		$suratMasuk = $this->suratMasuk->where('nomor_surat', $nomor_surat)->first();
		$suratKeluar = $this->suratKeluar->where('nomor_surat', $nomor_surat)->first();
		
		if($suratMasuk){
			$surat  = $suratMasuk;
			$folder = 'surat_masuk';
		}elseif($suratKeluar){
			$surat = $suratKeluar;
			$folder = 'surat_keluar';
		}else{
			return redirect()->back();
		}
		$data = [
			'title' 					=> 'Detail',
			'role' 					=> 'Kepala',
			'active_link' 			=> 'dashboard',
			'validation'			=> $this->validation,
			'detail_surat'			=> $surat,
			'folder'					=> $folder
		];

		return view('ketua/dashboard/detail', $data);
	}	
}