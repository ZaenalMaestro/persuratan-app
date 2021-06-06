<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Login implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
   {
      if(session('login')) {
         $level = strtolower(session('level'));
         return redirect()->to("/$level");
      }
   }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
            
   }
}