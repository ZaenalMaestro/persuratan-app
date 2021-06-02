<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluar extends Model
{
   protected $table      = 'surat_keluar';
   protected $primaryKey = 'nomor_surat';
   protected $allowedFields = [
      'nomor_surat', 
      'nomor_induk', 
      'tanggal',
      'penerima',
      'perihal',
      'file_surat',
      'disposisi',
   ];
}