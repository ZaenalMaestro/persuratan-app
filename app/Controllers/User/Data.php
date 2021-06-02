<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\PenelitianModel as Penelitian;
use App\Models\GambarModel as Gambar;

class Data extends BaseController
{
	public function __construct(){
		helper('text');
		$this->penelitian = new Penelitian();
		$this->gambar = new Gambar();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$data = [
			'title' 					=> 'Lihat Data',
			'role' 					=> 'User',
			'active_link' 			=> 'lihat_data',
			'daftar_penelitian'	=> $this->penelitian->where('id_user', session('id_user'))->findAll()
		];

		return view('user/penelitian/index', $data);
	}

	// menampilkan form tambah data penelitian baru
	public function create()
	{
		$data = [
			'title' 			=> 'Tambah Data Penelitian',
			'role' 			=> 'User',
			'active_link' 	=> 'lihat_data',
			'validation'	=> $this->validation
		];

		return view('user/penelitian/create', $data);
	}

	// tambah data penelitian baru
	public function store()
	{
		// get request files dan post
		$files 				= $this->request->getFiles();
		$data_penelitian 	= $this->request->getPost();

		// generate uniq id penelitian
		$id_penelitian = "penelitian_" . random_string('numeric',8);

		// // validasi input penelitian
		if(!$this->validation->run($data_penelitian, 'admin')){
			return redirect()->back()->withInput();
		}

		try {
			// insert data kedalam table penelitian
			$this->penelitian->insertData($data_penelitian, $files, $id_penelitian);

			// insert data ketable gambar dengan tipe "gambar" berdasarkan id_penelitian
			$this->gambar->insertGambar($files, $id_penelitian);

			// insert data ketable gambar dengan tipe "dokumentasi" berdasarkan id_penelitian
			$this->gambar->insertDokumentasi($files, $id_penelitian);

			session()->setFlashData('pesan', 'Penelitian berhasil ditambahkan !');
			return redirect()->to('/user/data');
		} catch (\Exception $e) {
			session()->setFlashData('pesan_error', 'Penelitian gagal ditambahkan !');
			return redirect()->to('/user/data');
		}
		
	}

	// menambhakan data penelitian baru
	public function edit($id_penelitian)
	{
		$data = [
			'title' 			=> 'Ubah Data Penelitian',
			'role' 			=> 'User',
			'active_link' 	=> 'lihat_data',
			'validation'	=> $this->validation,
			'penelitian'	=> $this->penelitian->getSingle($id_penelitian),
			'dokumentasi'	=> $this->gambar->dokumentasi($id_penelitian)
		];

		return view('user/penelitian/edit', $data);
	}

	// ubah data penelitian
	public function updatePenelitian()
	{
		$data_penelitian = $this->request->getPost();
		$jurnal = $this->request->getFile('jurnal');

		// validasi
		if(!$this->validation->run($data_penelitian, 'validasi_penelitian')) {
			return redirect()->back()->withInput();
		}

		try {
			$this->penelitian->updateData($data_penelitian, $jurnal);

			session()->setFlashData('pesan', 'Penelitian berhasil diubah');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->setFlashData('pesan_error', 'Penelitian gagal diubah');
			return redirect()->back();
		}
		
	}

	// ganti gambar penelitian
	public function updateGambar()
	{
		$file_gambar = $this->request->getFile('gambar');
		$new_gambar = $file_gambar->getName();
		$old_gambar  = $this->request->getPost('old_gambar');
		$id_penelitian  = $this->request->getPost('id_penelitian');

		// validasi gambar
		if(!$this->validation->run($this->request->getPost(), 'validasi_gambar')){
			return redirect()->back()->withInput();
		}

		// jika gambar baru sama dengan gambar lama
		if(!$new_gambar || $new_gambar == $old_gambar) {
			session()->setFlashData('pesan_error', 'Gambar tidak dibuah !');
			return redirect()->back();
		}

		// update gambar
		try {
			$this->gambar->updateGambar($file_gambar, $id_penelitian);
			session()->setFlashData('pesan', 'Gambar berhasil diubah');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->setFlashData('pesan_error', 'Gambar gagal diubah');
			return redirect()->back();
		}
	}


	// hapus data tabel penelitian dan gambar berdasarkan id_penelitian
	public function delete($id_penelitian)
	{
		$this->gambar->where('id_penelitian', $id_penelitian)->delete();
		$this->penelitian->delete($id_penelitian);

		session()->setFlashData('pesan', 'Penelitian berhasil dihapus !');
		return redirect()->back();
	}


	// insert gambar dokumentasi baru
	public function insertDokumentasi()
	{
		$files			= $this->request->getFiles();
		$id_penelitian = $this->request->getPost('id_penelitian');
		// validasi gambar doumentasi
		if(!$this->validation->run($this->request->getPost(), 'validasi_dokumentasi')){
			return redirect()->back()->withInput();
		}

		// update gambar
		try {
			$this->gambar->insertDokumentasi($files, $id_penelitian);
			session()->setFlashData('pesan', 'Gambar dokumentasi berhasil ditambahkan');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->setFlashData('pesan_error', 'Gambar dokumentasi gagal ditambahkan');
			return redirect()->back();
		}
	}

	// hapus gambar dokumentasi
	public function deleteDokumentasi($id_gambar)
	{
		$this->gambar->delete($id_gambar);
		session()->setFlashData('pesan', 'Dokumentasi berhasil dihapus');
		return redirect()->back();
	}

}
