<?php
namespace App\Controllers\Ketua;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratKeluar extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratKeluar = new \App\Models\SuratKeluar();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratKeluar->findAll();
		// filter data surat sekertaris

		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Ketua',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=> $surat,
			'folder'					=> 'surat_keluar'
		];

		return view('ketua/surat_keluar/index', $data);
	}

	// print surat keluar
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratKeluar->findAll(),
			'judul'	=> 'Laporan Surat Keluar'
		];
		$html =  view('ketua/surat_keluar/print_surat_keluar', $data);
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portair');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream(date("Y-m-d") . '_print_surat_keluar.pdf');
	}
}