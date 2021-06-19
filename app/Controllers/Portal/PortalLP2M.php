<?php
namespace App\Controllers\Portal;
use App\Controllers\BaseController;

use App\Models\PenelitianModel as Penelitian;

class PortalLP2M extends BaseController
{

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		return view('portal/index');
	}
}