<?php 

namespace App\Models;

use CodeIgniter\Model;

class TemplateSurat extends Model{
   protected $table      = 'template_surat';
   protected $primaryKey = 'id';
   protected $allowedFields = [
      'nama_template', 'template' 
   ];
}