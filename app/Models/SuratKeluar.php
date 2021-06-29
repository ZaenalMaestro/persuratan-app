<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluar extends Model
{
   protected $table      = 'surat_keluar';
   protected $allowedFields = [
      'nomor_surat', 
      'perihal', 
      'isi_surat',
      'penerima',
      'komentar',
      'status_komentar',
      'tanggal_surat',
   ];
}