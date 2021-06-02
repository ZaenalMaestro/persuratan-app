<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class PenerimaSurat extends BaseController
{
	public function __construct(){
		helper('text');
		$this->dataUser = new \App\Models\DataUser();
		$this->suratMasuk = new \App\Models\SuratMasuk();
		$this->suratKeluar = new \App\Models\SuratKeluar();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman penerima surat
	public function index()
	{
		$data = [
			'title' 					=> 'Penerima Surat',
			'role' 					=> 'Admin',
			'active_link' 			=> 'penerima_surat',
			'penerima_surat'		=> $this->dataUser->findAll(),
			'validation'			=> $this->validation
		];

		return view('admin/penerima_surat/index', $data);
	}

	// tambahkan penerima surat
	public function create()
	{
		$request = $this->request->getPost();

		$data = [
			'nomor_induk'  => $request['nomor-induk'], 
			'password'		=> $request['password'],
			'nama_lengkap' => $request['nama-penerima']
		];


		$this->dataUser->insert($data);

		session()->setFlashData('pesan', 'Penerima surat berhasil ditambahkan');
		return redirect()->to('/admin/penerima-surat');
	}

	// hapus penerima surat masuk
	public function destroy()
	{
		$penerima = $this->request->getPost('penerima');
		$nomor_induk = $this->request->getPost('nomor-induk');
		$this->suratMasuk->where('penerima', $penerima)->delete();
		$this->suratKeluar->where('penerima', $penerima)->delete();
		$this->dataUser->delete($nomor_induk);

		session()->setFlashData('pesan', 'Penerima surat berhasil dihapus!');
		return redirect()->back();
	}
}