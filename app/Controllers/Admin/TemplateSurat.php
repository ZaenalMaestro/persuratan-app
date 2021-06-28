<?php 
namespace App\Controllers\Admin;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;

use App\Controllers\BaseController;

class TemplateSurat extends BaseController{
   public function __construct(){
      $this->templateModel = new \App\Models\TemplateSurat();
   }

   // menampilkan daftar template
   public function index()
   {
      $data = [
			'title' 					=> 'Template Surat',
			'role' 					=> 'Admin',
			'active_link' 			=> 'template_surat',
         'templates'          => $this->templateModel->findAll()
		];
      return view('admin/template_surat/index', $data);
   }

   // menampilkan form template surat baru
   public function create()
   {
      $data = [
			'title' 					=> 'Template Surat',
			'role' 					=> 'Admin',
			'active_link' 			=> 'template_surat',
		];
      return view('admin/template_surat/insert', $data);
   }

   // menampilkan suamua template (JSON)
   public function allTemplate()
   {
      $response = service('response');
      $data = [
         'templates' => $this->templateModel->findAll()
      ];

      return $response->setStatusCode(200)
                        ->setJSON($data);
   }

   // buat template baru
   public function insert()
   {
      $response = service('response');
      $incomingRequest = service('request');
      $request = $incomingRequest->getJSON();

      $data = [
         'nama_template' => $request->nama_template,
         'template' => $request->template,
      ];

      try {
         $this->templateModel->insert($data);
         return $response->setStatusCode(200)
                              ->setJSON(['pesan' => 'template berhasil dibuat']);
      } catch (\Exception $error) {
         return $response->setStatusCode(500)
                              ->setJSON(['pesan' => 'template gagal dibuat']);
      }
   }

   // menampilkan form edit surat
   public function edit($id)
   {
      $data = [
			'title' 					=> 'Template Surat',
			'role' 					=> 'Admin',
			'active_link' 			=> 'template_surat',
         'template'           => $this->templateModel->where('id', $id)->first()
		];
      return view('admin/template_surat/edit', $data);
   }

   // buat template baru
   public function update()
   {
      $response = service('response');
      $incomingRequest = service('request');
      $request = $incomingRequest->getJSON();

      $data = [
         'nama_template' => $request->nama_template,
         'template' => $request->template,
      ];

      try {
         $this->templateModel->update($request->id, $data);
         return $response->setStatusCode(200)
                              ->setJSON(['pesan' => 'template berhasil diubah']);
      } catch (\Exception $error) {
         return $response->setStatusCode(500)
                              ->setJSON(['pesan' => 'template gagal diubah']);
      }
   }

   // hapus tempalate surat
   public function destroy()
   {
      $id = $this->request->getPost('id');
      $this->templateModel->delete($id);

      session()->setFlashData('pesan', 'Template surat berhasil dihapus!');
		return redirect()->back();
   }
}