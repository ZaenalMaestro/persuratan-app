<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratKeluar extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratKeluar = new \App\Models\SuratKeluar();
		$this->templateModel = new \App\Models\TemplateSurat();
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{		
		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Admin',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=>  $this->suratKeluar->findAll(),
			'validation'			=> $this->validation,
			'tanggal_surat'      => '',
		];

		return view('admin/surat_keluar/index', $data);
	}

	// menampilkan form insert data
	public function insert()
	{
		// penomoran surat
		$no_urut_surat = 2370;
		$totalSuratKeluar = count($this->suratKeluar->findAll());
		$tahun_sekarang = date('Y');
		
		if($totalSuratKeluar == 0){
			$nomor_surat = $no_urut_surat + 1;
			$format_nomor_surat = "$nomor_surat/UN36.11/LP2M/$tahun_sekarang";
		}else{
			$nomor_surat = $totalSuratKeluar + $no_urut_surat + 1;
			$format_nomor_surat = "$nomor_surat/UN36.11/LP2M/$tahun_sekarang";
		}

		$data = [
			'title' 			=> 'Buat Surat Keluar',
			'role' 			=> 'Admin',
			'active_link' 	=> 'surat_keluar',
			'validation'	=> $this->validation,
			'templates'		=> $this->templateModel->findAll(),
			'penerima_surat'		=> $this->dataUser->findAll(),
			'nomor_surat'	=> $format_nomor_surat,
		];

		return view('admin/surat_keluar/insert', $data);
	}

	 // buat surat keluar baru
	public function create()
	{
		$response = service('response');
		$incomingRequest = service('request');
		$request = $incomingRequest->getJSON();

		$data = [
			'nomor_surat' => $request->nomor_surat, 
			'perihal'=> $request->perihal_surat, 
			'isi_surat'=> $request->isi_surat,
			'penerima' => $request->penerima_surat,
			'komentar' => '-',
			'status_komentar' => 'revisi',
			'tanggal_surat' => $request->tanggal_surat,
		];

		try {
			$this->suratKeluar->insert($data);
			return $response->setStatusCode(200)
										->setJSON(['pesan' => 'Surat keluar berhasil dibuat']);
		} catch (\Exception $error) {
			return $response->setStatusCode(500)
										->setJSON(['pesan' => 'Surat keluar gagal dibuat']);
		}
	}

	public function edit($id)
	{
		// redirect ke index surat keluar jika surat telah diterima
		$surat = $this->suratKeluar->where('id', $id)->first();

		$data = [
			'title' 					=> 'Edit Surat Keluar',
			'role' 					=> 'Admin',
			'active_link' 			=> 'surat_keluar',
			'validation'			=> $this->validation,
			'templates'				=> $this->templateModel->findAll(),			
			'penerima_surat'		=> $this->dataUser->findAll(),
			'surat_keluar'			=> $surat,
		];

		return view('admin/surat_keluar/edit', $data);
	}

	// update surat masuk
	public function update()
	{
		$response = service('response');
		$incomingRequest = service('request');
		$request = $incomingRequest->getJSON();

		$data = [
			'id' => $request->id,
			'nomor_surat' => $request->nomor_surat, 
			'perihal'=> $request->perihal_surat, 
			'isi_surat'=> $request->isi_surat,
			'penerima' => $request->penerima_surat,
			'tanggal_surat' => $request->tanggal_surat,
		];

		try {
			$this->suratKeluar->save($data);
			return $response->setStatusCode(200)
										->setJSON(['pesan' => 'Surat keluar berhasil diubah']);
		} catch (\Exception $error) {
			return $response->setStatusCode(500)
										->setJSON(['pesan' => 'Surat keluar gagal diubah']);
		}
	}

	// hapus surat masuk
	public function destroy()
	{
		$id = $this->request->getPost('id');
		$this->suratKeluar->delete($id);

		session()->setFlashData('pesan', 'Surat keluar berhasil dihapus!');
		return redirect()->back();
	}

	// print surat keluar
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratKeluar->where('status_komentar', 'diterima')->find(),
		];

		return  view('download/all_surat_keluar', $data);
	}

	public function download($id)
	{
		$data = [
			'surat_keluar' => $this->suratKeluar->where('id', $id)->first(),
		];

		return view('download/surat_keluar', $data);
	}

	public function lihat($id)
	{
		$data = [
			'surat_keluar' => $this->suratKeluar->where('id', $id)->first(),
		];

		return view('download/lihat', $data);
	}

	public function detail($id)
	{
		$data = [
			'surat_keluar' => $this->suratKeluar->where('id', $id)->first(),
			// type view detail => dihalaman lihat_k tombol kembali redirect ke dashboard
			'type_view' => 'detail'
		];

		return view('download/lihat_k', $data);
	}
}