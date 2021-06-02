<?php
namespace App\Controllers\Admin;
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
			return ($data['tanggal'] == date('Y-m-d'));
		});

		// menampilkan data surat yang telah disposisi
		$disposisi = array_filter($surat, function($data) {
			return ($data['disposisi'] == 'disposisi');
		});

		$data = [
			'title' 					=> 'Dashboard',
			'role' 					=> 'Admin',
			'active_link' 			=> 'dashboard',
			'surat_hari_ini'		=> $suratHariIni,
			'total_surat_masuk'	=> count($suratMasuk),
			'total_surat_keluar'	=> count($suratKeluar),
			'total_disposisi'		=> count($disposisi),
			'penerima_surat'		=> $this->dataUser->findAll(),
			'validation'			=> $this->validation
		];

		return view('admin/dashboard/index', $data);
	}

	public function disposisi()
	{
		$request = $this->request->getPost();
		if(!$this->validation->run($request, 'disposisi')){
			return redirect()->back()->withInput();
		}
		$data = [
			'nomor_surat' 	=> $request['nomor-surat'],
			'penerima' 		=> $request['penerima'],
			'disposisi'		=> 'disposisi'
		];

		$suratMasuk  = $this->suratMasuk->where('nomor_surat', $data['nomor_surat'])->first();
		$suratKeluar = $this->suratKeluar->where('nomor_surat', $data['nomor_surat'])->first();

		if($suratMasuk){
			$this->suratMasuk->save($data);
			session()->setFlashData('pesan', 'Surat masuk berhasil disposis kepada ' . $data['penerima']);
			return redirect()->back();
		}else if($suratKeluar){
			$this->suratKeluar->save($data);
			session()->setFlashData('pesan', 'Surat keluar berhasil disposis kepada ' . $data['penerima']);
			return redirect()->back();
		}else{
			session()->setFlashData('pesan_error', 'Surat tidak dapat didisposisi !');
			return redirect()->back();
		}
	}

	
}