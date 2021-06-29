<?php
namespace App\Controllers\Sekertaris;
use App\Controllers\BaseController;

use Dompdf\Dompdf;

class SuratKeluar extends BaseController
{
	public function __construct(){
		helper('text');
		date_default_timezone_set('Asia/Hong_Kong');
		$this->suratKeluar = new \App\Models\SuratKeluar();
		$this->templateModel = new \App\Models\TemplateSurat();
		$this->validation =  \Config\Services::validation();
	}

	// menampilkan halaman dashborad - data penelitian
	public function index()
	{
		$surat = $this->suratKeluar->findAll();

		$data = [
			'title' 					=> 'Surat Keluar',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_keluar',
			'surat_hari_ini'		=> $surat,
			'validation'			=> $this->validation
		];

		return view('sekertaris/surat_keluar/index', $data);
	}

	// menampilkan form insert data
	public function insert()
	{
		$data = [
			'title' 					=> 'Buat Surat Keluar',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_keluar',
			'validation'			=> $this->validation,
			'penerima_surat'		=> $this->dataUser->findAll()
		];

		return view('sekertaris/surat_keluar/insert', $data);
	}

	public function create()
	{
		$request 	= $this->request->getPost();
		$fileSurat 	= $this->request->getFile('file-surat');
		$nama_surat = $fileSurat->getRandomName();

		// validasi nomor surat
		$nomor_surat_exist = $this->suratKeluar->where('nomor_surat', $request['nomor-surat'])->first();
		if($nomor_surat_exist) {
			// validasi input surat masuk/ keluar
			$this->validation->setError('nomor-surat', 'nomor surat telah digunakan');
			return redirect()->back()->withInput();
		}

		// validasi format surat
		$segment_surat = explode('/', $request['nomor-surat']);
		if(count($segment_surat) !== 4) {
			$this->validation->setError('nomor-surat', 'format surat tidak sesuai');
			return redirect()->back()->withInput();
		}

		// validasi input surat masuk/ keluar
		if(!$this->validation->run($request, 'surat_masuk')){
			return redirect()->back()->withInput();
		}

		$data = [
			'nomor_surat' 	=> $request['nomor-surat'],
			'nomor_induk'	=> session('nomor_induk'),
			'tanggal' 		=> htmlspecialchars($request['tanggal']),
			'penerima' 		=> htmlspecialchars($request['penerima']),
			'perihal' 		=> htmlspecialchars($request['perihal']),
			'file_surat' 	=> $nama_surat,
			'disposisi' 	=> 'menunggu'
		];

		// insert surat masuk
		$this->suratKeluar->insert($data);

		// upload surat
		$fileSurat->move(ROOTPATH . 'public/surat/surat_keluar', $nama_surat);

		session()->setFlashData('pesan', 'Surat keluar berhasil dibuat');
		return redirect()->to('/sekertaris/surat-keluar');
	}

	public function edit($id)
	{
		// redirect ke index surat keluar jika surat telah diterima
		$surat = $this->suratKeluar->where('id', $id)->first();
		if($surat['status_komentar'] == 'diterima') {
			return redirect()->to('/sekertaris/surat-keluar');
		}

		$data = [
			'title' 					=> 'Edit Surat Keluar',
			'role' 					=> 'Sekertaris',
			'active_link' 			=> 'surat_keluar',
			'validation'			=> $this->validation,
			'surat_keluar'			=> $surat,
		];

		return view('sekertaris/surat_keluar/edit', $data);
	}

	// hapus surat masuk
	public function destroy()
	{
		$nomor_surat = $this->request->getPost('nomor-surat');
		$this->suratKeluar->delete($nomor_surat);

		session()->setFlashData('pesan', 'Surat keluar berhasil dihapus!');
		return redirect()->back();
	}

	// print surat keluar
	public function printSurat()
	{
		$data = [
			'surat'		=>  $this->suratKeluar->findAll(),
			'judul'	=> 'Laporan Surat Keluar'
		];
		// return view('admin/surat_masuk/print_surat_masuk', $data);
		$html =  view('sekertaris/surat_keluar/print_surat_keluar', $data);
		
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

	public function tambahKomentar()
	{
		$response = service('response');
		$incomingRequest = service('request');
		$request = $incomingRequest->getJSON();

		$data = [
			'komentar' => $request->komentar,
		];

		try {
			$this->suratKeluar->update($request->id, $data);
			return $response->setStatusCode(200)
									->setJSON(['pesan' => 'Komentar telah ditambahkan']);
		} catch (\Exception $error) {
			return $response->setStatusCode(500)
									->setJSON(['pesan' => 'Komentar gagal ditambahkan']);
		}
	}

	public function terimaSurat()
	{
		$id = $this->request->getPost('id');

		$data = [
			'komentar' => '-',
			'status_komentar' => 'diterima',
		];

		$this->suratKeluar->update($id, $data);

		session()->setFlashData('pesan', 'Surat keluar telah diterima');
		return redirect()->back();
	}
}