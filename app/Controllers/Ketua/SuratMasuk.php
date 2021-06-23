<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratMasuk extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratMasuk = new \App\Models\SuratMasuk();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratMasuk->findAll();

		$data = [
			'title' 					=> 'Surat Masuk',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'surat_masuk',
			'surat_hari_ini'		=> $surat,
			'folder'					=> 'surat_masuk'
		];

		return view('ketua/surat_masuk/index', $data);
	}

	// print surat masuk
	public function printSurat()
	{
		$path = base_url('assets/img/asset-unm/Logo_Besar.png');
		$base64 = base64_encode($path);
		// dd($base64);
		$data = [
			'surat'		=>  $this->suratMasuk->findAll(),
			'judul'	=> 'Laporan Surat Masuk'
		];
		// return view('admin/surat_masuk/print_surat_masuk', $data);
		$html =  view('ketua/surat_masuk/print_surat_masuk', $data);
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portair');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream(date("Y-m-d") . '_print_surat_masuk.pdf');
	}
}