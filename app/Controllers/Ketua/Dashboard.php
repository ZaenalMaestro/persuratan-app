<?php
namespace App\Controllers\Ketua;
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

		$semuaSurat = array_merge($suratMasuk, $suratKeluar);

		// filter data surat hari ini
		$suratHariIni = array_filter($semuaSurat, function($data) {
			if (!isset($data['tanggal'])) {
				return ($data['tanggal_surat'] == date('Y-m-d') && $data['penerima'] == session('nama') && $data['status_komentar'] == 'diterima');
			}
			return ($data['tanggal'] == date('Y-m-d') && $data['penerima'] == session('nama'));
		});

		// menampilkan data surat yang telah disposisi
		$disposisi = array_filter($suratMasuk, function($data) {
			return $data;
		});

		$data = [
			'title' 					=> 'Dashboard',
			'role' 					=> 'Ketua',
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

	public function disposisi()
	{
		$request = $this->request->getPost();
		if(!$this->validation->run($request, 'disposisi')){
			return redirect()->back()->withInput();
		}
		$data = [
			'id' 	=> $request['id-surat'],
			'penerima' 		=> $request['penerima'],
			'disposisi'		=> 'disposisi'
		];
		
		$this->suratMasuk->save($data);
		session()->setFlashData('pesan', 'Surat masuk berhasil disposis kepada ' . $data['penerima']);
		return redirect()->back();
	}

	public function show($id)
	{		
		$data = [
			'title' 					=> 'Detail',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'dashboard',
			'validation'			=> $this->validation,
			'detail_surat'			=> $this->suratMasuk->where('id', $id)->first(),
			'folder'					=> 'surat_masuk'
		];

		return view('ketua/dashboard/detail', $data);
	}	
}