<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AdminModel;

class Login extends BaseController
{
	public function __construct()
	{
		$this->validation =  \Config\Services::validation();
		$this->user 		=  new UserModel();
		$this->admin 		=  new AdminModel();
	}

	public function index()
	{
		$data = [
			'validation' => $this->validation
		];

		return view('login', $data);
	}




	public function signIn()
	{		
		// validasi inputan
		$login = $this->request->getPost();
		if(!$this->validation->run($login, 'login')) {
			return redirect()->back()->withInput();
		}
		$data_admin = $this->admin->where('username', $login['username'])->first();
		// jika yang login adalah admin
		if($data_admin) {
			if (password_verify($login['password'], $data_admin['password'])) {
				$data = [
					'login' => true,
					'role' => 'admin',
					'id_admin' => $data_admin['id_admin']
				];

				session()->set($data);
				return redirect()->to('/admin');
			} else {
				$this->validation->setError('password', 'Password tidak valid');
				return redirect()->back()->withInput();
			}
		} else{
			$this->validation->setError('nomor_induk', 'username atau password tidak valid');
			$this->validation->setError('password', 'username atau password tidak valid');
			return redirect()->back()->withInput();
		}
	}

	public function logOut()
	{
		session()->destroy();
		return redirect()->to('/');
	}
}
