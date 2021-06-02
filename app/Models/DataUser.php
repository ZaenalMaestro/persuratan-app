<?php

namespace App\Models;

use CodeIgniter\Model;

class DataUser extends Model
{
   protected $table      = 'data_user';
   protected $primaryKey = 'nomor_induk';
   protected $allowedFields = [
      'nomor_induk', 
      'password',
      'nama_lengkap',
      'level'
   ];
}