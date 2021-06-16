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

		// validasi penerima surat (unik)
		$penerima_exist = $this->dataUser->where('nama_lengkap', $request['nama-penerima'])->first();
		if($penerima_exist) {
			$this->validation->setError('form-tambah', 'error');
			$this->validation->setError('nama-penerima', 'nama penerima surat telah ada');
			return redirect()->back()->withInput();
		}

		// validasi nomor induk (unik)
		$nomor_induk_exist = $this->dataUser->where('nomor_induk', $request['nomor-induk'])->first();
		if($nomor_induk_exist) {
			$this->validation->setError('form-tambah', 'error');
			$this->validation->setError('nomor-induk', 'nomor induk telah digunakan');
			return redirect()->back()->withInput();
		}

		// validasi penerima surat (semua input)
		if(!$this->validation->run($request, 'penerima_surat')){
			$this->validation->setError('form-tambah', 'error');
			return redirect()->back()->withInput();
		}

		$data = [
			'nomor_induk'  => $request['nomor-induk'], 
			'password'		=> password_hash($request['password'], PASSWORD_BCRYPT),
			'nama_lengkap' => $request['nama-penerima'],
			'level'			=> 'ketua'
		];


		$this->dataUser->insert($data);

		session()->setFlashData('pesan', 'Penerima surat berhasil ditambahkan');
		return redirect()->to('/admin/penerima-surat');
	}

	// update surat masuk
	public function update()
	{
		$request = $this->request->getPost();

		// jika nama penerima diubah
		if($request['nama-penerima'] !== $request['nama-penerima-lama']) {
			// validasi penerima surat (unik)
			$penerima_exist = $this->dataUser->where('nama_lengkap', $request['nama-penerima'])->first();
			if($penerima_exist) {
				$this->validation->setError('form-edit', 'error');
				$this->validation->setError('nama-penerima', 'nama penerima surat telah ada');
				return redirect()->back()->withInput();
			}

			// ubah penerima ditabel surat masuk dan surat keluar
			$penerima_lama = $request['nama-penerima-lama'];
			$penerima_baru = $request['nama-penerima'];
			$this->suratMasuk->updateData($penerima_lama, $penerima_baru);
			$this->suratKeluar->updateData($penerima_lama, $penerima_baru);
		}

		// validasi input
		if(!$this->validation->run($request, 'edit_penerima_surat')){
			$this->validation->setError('form-edit', 'error');
			return redirect()->back()->withInput();
		}


		// jika nomor induk diubah
		if($request['nomor-induk-lama'] !== $request['nomor-induk'])
		{
			// validasi nomor induk (unik)
			$nomor_induk_exist = $this->dataUser->where('nomor_induk', $request['nomor-induk'])->first();
			if($nomor_induk_exist) {
				$this->validation->setError('form-edit', 'error');
				$this->validation->setError('nomor-induk', 'nomor induk telah digunakan');
				return redirect()->back()->withInput();
			}
		}

		$data = [
			'nomor_induk'  => $request['nomor-induk'], 
			'nama_lengkap' => $request['nama-penerima']
		];

		if($request['password']){
			$data['password'] = password_hash($request['password'], PASSWORD_BCRYPT);
		}


		$this->dataUser->update($request['nomor-induk-lama'], $data);

		session()->setFlashData('pesan', 'Penerima surat berhasil diubah');
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