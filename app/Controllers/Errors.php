<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Config\Services;

class Errors extends BaseController
{
    public function error404()
    {

        $request = Services::request();
        $urls = $request->uri->getSegments();
        if(in_array($urls[0], [
            'table', 'config', 'dashboard'
        ])){
            return view('errors/html/error_404');
        }
        return view('home_page/errors/error_404');
        
    }
}
