<?php
namespace App\Controllers\Sekertaris;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratMasuk extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratMasuk = new \App\Models\SuratMasuk();
		$this->dataUser = new \App\Models\DataUser();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratMasuk->findAll();
		$suratMasuk = array_filter($surat, function($data) {
			return $data['penerima'] !== session('nama');
		});
		// filter data surat sekertaris
		$data = [
			'title' 					=> 'Surat Masuk',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_masuk',
			'surat_hari_ini'		=> $suratMasuk,
			'penerima_surat'		=> $this->dataUser->findAll(),
			'validation'			=> $this->validation
		];

		return view('sekertaris/surat_masuk/index', $data);
	}

	public function lihat($id)
	{
		$data = [
			'title' 					=> 'Lihat Surat Masuk',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_masuk',
			'validation'			=> $this->validation,
			'surat_masuk'			=> $this->suratMasuk->where('id', $id)->first(),
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('pdf_view', $data);
	}

	// menampilkan form insert data
	public function insert()
	{
		$data = [
			'title' 					=> 'Buat Surat Masuk',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_masuk',
			'validation'			=> $this->validation,
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('sekertaris/surat_masuk/insert', $data);
	}

	public function create()
	{
		$request 	= $this->request->getPost();
		$fileSurat 	= $this->request->getFile('file-surat');
		$nama_surat = $fileSurat->getRandomName();

		// validasi nomor surat
		$nomor_surat_exist = $this->suratMasuk->where('nomor_surat', $request['nomor-surat'])->first();
		if($nomor_surat_exist) {
			// validasi input surat masuk/ keluar
			$this->validation->setError('nomor-surat', 'nomor surat telah digunakan');
			return redirect()->back()->withInput();
		}

		// validasi input
		if(!$this->validation->run($request, 'surat_masuk')){
			return redirect()->back()->withInput();
		}

		$data = [
			'nomor_surat' 	=> $request['nomor-surat'],
			'nomor_induk' 	=> session('nomor_induk'),
			'tanggal' 		=> htmlspecialchars($request['tanggal']),
			'penerima' 		=> htmlspecialchars($request['penerima']),
			'perihal' 		=> htmlspecialchars($request['perihal']),
			'file_surat' 	=> $nama_surat,
			'disposisi' 	=> 'menunggu'
		];

		// insert surat masuk
		$this->suratMasuk->insert($data);

		// upload surat
		$fileSurat->move(ROOTPATH . '../public_html/surat/surat_masuk', $nama_surat);

		session()->setFlashData('pesan', 'Surat masuk berhasil dibuat');
		return redirect()->to('/sekertaris/surat-masuk');
	}

	public function edit($id)
	{
		$data = [
			'title' 					=> 'Edit Surat Masuk',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_masuk',
			'validation'			=> $this->validation,
			'surat_masuk'			=> $this->suratMasuk->where('id', $id)->first(),
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('sekertaris/surat_masuk/edit', $data);
	}

	// update surat masuk
	public function update()
	{
		$request 	= $this->request->getPost();
		$fileSurat 	= $this->request->getFile('file-surat');
		$nama_surat = $fileSurat->getRandomName();

		// validasi ketersediaan nomor surat
		if ($request['nomor-surat-lama'] != $request['nomor-surat-baru']) {
			$nomor_surat_exist = $this->suratMasuk->where('nomor_surat', $request['nomor-surat-baru'])->first();
			if($nomor_surat_exist) {
				// validasi input nomor surat masuk/
				$this->validation->setError('nomor-surat-baru', 'nomor surat telah digunakan');
				return redirect()->back()->withInput();
			}
		}		

		// validasi input
		if(!$this->validation->run($request, 'form_edit_surat_masuk')){
			return redirect()->back()->withInput();
		}

		$data = [
			'nomor_surat' 	=> $request['nomor-surat-baru'],
			'tanggal' 		=> htmlspecialchars($request['tanggal']),
			'penerima' 		=> htmlspecialchars($request['penerima']),
			'perihal' 		=> htmlspecialchars($request['perihal']),
		];

		if($fileSurat->getSize() > 0) {
			$data['file_surat'] = $nama_surat;
			// upload surat
			$fileSurat->move(ROOTPATH . '../public_html/surat/surat_masuk', $nama_surat);
		}

		// insert surat masuk
		$this->suratMasuk->update($request['id'], $data);

		session()->setFlashData('pesan', 'Surat masuk berhasil diubah');
		return redirect()->to('/sekertaris/surat-masuk');
	}

	// hapus surat masuk
	public function destroy()
	{
		$nomor_surat = $this->request->getPost('nomor-surat');
		$this->suratMasuk->delete($nomor_surat);

		session()->setFlashData('pesan', 'Surat masuk berhasil dihapus!');
		return redirect()->back();
	}

	// print surat masuk
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratMasuk->findAll(),
			'judul'	=> 'Laporan Surat Masuk'
		];
		// return view('admin/surat_masuk/print_surat_masuk', $data);
		$html =  view('sekertaris/surat_masuk/print_surat_masuk', $data);
		
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