<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsAdmin implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
   {
      if(!session('login')) {
         return redirect()->to('/');
      }elseif(session('role') != 'admin') {
         return redirect()->to('/' . session('role'));
      }
   }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
            
   }
}