<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsLogin implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
   {
      if(session('login')) {
         if (session('role') == 'admin') {
            return redirect()->to('/admin');
         }
         
         if (session('role') == 'user') {
            return redirect()->to('/user');
         }
      }
   }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
            
   }
}