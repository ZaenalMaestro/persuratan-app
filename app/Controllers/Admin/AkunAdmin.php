<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class AkunAdmin extends BaseController
{
	public function __construct(){
		helper('text');
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{

		$data = [
			'title' 					=> 'Ganti Password',
			'role' 					=> 'Admin',
			'active_link' 			=> 'password',
			'validation'			=> $this->validation
		];

		return view('admin/akun/ganti_password', $data);
	}

	public function update()
	{

		$request = $this->request->getPost();

		$this->dataUser->update($request['nomor_induk'], ['password' => password_hash($request['password'], PASSWORD_BCRYPT)]);

		session()->setFlashData('pesan', 'Password berhasil diubah');
		return redirect()->back();
	}

}