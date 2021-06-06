<?php
namespace App\Controllers\Sekertaris;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class SuratKeluar extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratKeluar = new \App\Models\SuratKeluar();
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratKeluar->findAll();
		// filter data surat sekertaris
		$suratKeluar = array_filter($surat, function($data) {
			return ($data['nomor_induk'] == '44444' || strtolower($data['penerima']) == 'sekertaris');
		});
		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=> $suratKeluar,
			'validation'			=> $this->validation
		];

		return view('sekertaris/surat_keluar/index', $data);
	}

	// menampilkan form insert data
	public function insert()
	{
		$data = [
			'title' 					=> 'Buat Surat Keluar',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_keluar',
			'validation'			=> $this->validation,
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('sekertaris/surat_keluar/insert', $data);
	}

	public function create()
	{
		$request 	= $this->request->getPost();
		$fileSurat 	= $this->request->getFile('file-surat');
		$nama_surat = $fileSurat->getRandomName();

		// validasi nomor surat
		$nomor_surat_exist = $this->suratKeluar->where('nomor_surat', $request['nomor-surat'])->first();
		if($nomor_surat_exist) {
			// validasi input surat masuk/ keluar
			$this->validation->setError('nomor-surat', 'nomor surat telah digunakan');
			return redirect()->back()->withInput();
		}

		// validasi format surat
		$segment_surat = explode('/', $request['nomor-surat']);
		if(count($segment_surat) !== 4) {
			$this->validation->setError('nomor-surat', 'format surat tidak sesuai');
			return redirect()->back()->withInput();
		}

		// validasi input surat masuk/ keluar
		if(!$this->validation->run($request, 'surat_masuk')){
			return redirect()->back()->withInput();
		}

		$data = [
			'nomor_surat' 	=> $request['nomor-surat'],
			'nomor_induk'	=> session('nomor_induk'),
			'tanggal' 		=> htmlspecialchars($request['tanggal']),
			'penerima' 		=> htmlspecialchars($request['penerima']),
			'perihal' 		=> htmlspecialchars($request['perihal']),
			'file_surat' 	=> $nama_surat,
			'disposisi' 	=> 'menunggu'
		];

		// insert surat masuk
		$this->suratKeluar->insert($data);

		// upload surat
		$fileSurat->move(ROOTPATH . 'public/surat/surat_keluar', $nama_surat);

		session()->setFlashData('pesan', 'Surat keluar berhasil dibuat');
		return redirect()->to('/sekertaris/surat-keluar');
	}

	public function edit()
	{
		$segmant = $this->request->uri->getSegments();
		$nomor_surat = "$segmant[2]/$segmant[3]/$segmant[4]/$segmant[5]";
		$surat = $this->suratKeluar->where('nomor_surat', $nomor_surat)->first();
		$data = [
			'title' 					=> 'Edit Surat Keluar',
			'role' 					=> 'Admin',
			'active_link' 			=> 'surat_keluar',
			'validation'			=> $this->validation,
			'surat_keluar'			=> $surat,
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('sekertaris/surat_keluar/edit', $data);
	}

	// update surat masuk
	public function update()
	{
		$request 	= $this->request->getPost();
		$fileSurat 	= $this->request->getFile('file-surat');
		$nama_surat = $fileSurat->getRandomName();

		// validasi input
		if(!$this->validation->run($request, 'form_edit_surat_masuk')){
			return redirect()->back()->withInput();
		}


		// jika nomor surat diubah
		$nomor_surat = $request['nomor-surat-lama'];
		if ($request['nomor-surat-baru'] !== $request['nomor-surat-lama']) {
			// validasi format surat
			$segment_surat = explode('/', $request['nomor-surat-baru']);
			if(count($segment_surat) !== 4) {
				$this->validation->setError('nomor-surat-baru', 'format surat tidak sesuai');
				return redirect()->back()->withInput();
			}

			// cek nomor surat
			$nomor_surat_exist = $this->suratKeluar->where('nomor_surat', $request['nomor-surat-baru'])->first();
			if($nomor_surat_exist) {
				$this->validation->setError('nomor-surat-baru', 'nomor surat telah digunakan');
				return redirect()->back()->withInput();
			}

			$nomor_surat = $request['nomor-surat-baru'];
		}

		$data = [
			'nomor_surat' 	=> $nomor_surat,
			'tanggal' 		=> htmlspecialchars($request['tanggal']),
			'penerima' 		=> htmlspecialchars($request['penerima']),
			'perihal' 		=> htmlspecialchars($request['perihal']),
		];

		if($fileSurat->getSize() > 0) {
			$data['file_surat'] = $nama_surat;
			// upload surat
			$fileSurat->move(ROOTPATH . 'public/surat/surat_keluar', $nama_surat);
		}

		// insert surat masuk
		$this->suratKeluar->update($request['nomor-surat-lama'], $data);

		session()->setFlashData('pesan', 'Surat keluar berhasil diubah');
		return redirect()->to('/sekertaris/surat-keluar');
	}

	// hapus surat masuk
	public function destroy()
	{
		$nomor_surat = $this->request->getPost('nomor-surat');
		$this->suratKeluar->delete($nomor_surat);

		session()->setFlashData('pesan', 'Surat keluar berhasil dihapus!');
		return redirect()->back();
	}
}