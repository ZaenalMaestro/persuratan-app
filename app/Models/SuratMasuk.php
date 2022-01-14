<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasuk extends Model
{
   protected $table      = 'surat_masuk';
   protected $primaryKey = 'id';
   protected $allowedFields = [
      'nomor_surat', 
      'nomor_induk', 
      'tanggal',
      'penerima',
      'perihal',
      'file_surat',
      'disposisi',
   ];

   // update surat masuk (penerima surat masuk) jika data_user (nama lengkap) diubah
   public function updateData($penerima_lama, $penerima_baru)
   {
      $db      = \Config\Database::connect();
      $builder = $db->table($this->table);

      $data = [
         'penerima' => $penerima_baru
      ];
     
      $builder->where('penerima', $penerima_lama);
      $builder->update($data);
   }

}