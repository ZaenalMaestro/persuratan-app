<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function __construct()
	{
		$this->validation = \Config\Services::validation();
		$this->dataUser 		= new \App\Models\DataUser();
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
		// // validasi inputan
		$login = $this->request->getPost();
		if(!$this->validation->run($login, 'login')) {
			return redirect()->back()->withInput();
		}

		// cek login user
		$data_login = $this->dataUser->where('nomor_induk', $login['nomor-induk'])->first();
		if($data_login) {
			if (password_verify($login['password'], $data_login['password'])) {
				$data = [
					'login' 			=> true,
					'level' 			=> strtolower($data_login['level']),
					'nama' 			=> $data_login['nama_lengkap'],
					'nomor_induk' 	=> $data_login['nomor_induk']
				];

				session()->set($data);
				$level = strtolower($data['level']);
				return redirect()->to("/$level");
			} else {
				$this->validation->setError('password', 'Password tidak valid');
				return redirect()->back()->withInput();
			}
		} else{
			$this->validation->setError('nomor-induk', 'username atau password tidak valid');
			$this->validation->setError('password', 'username atau password tidak valid');
			return redirect()->back()->withInput();
		}
	}

	public function logOut()
	{
		session()->destroy();
		return redirect()->to('/login');
	}
}
