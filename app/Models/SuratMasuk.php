<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasuk extends Model
{
   protected $table      = 'surat_masuk';
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