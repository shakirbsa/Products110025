<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;


class Api extends REST_Controller
{protected $request="";

    public function __construct(RequestInterface $request=null)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('pro_ducts');
    }
    public function add()
    {
       if(true){
           echo "<pre>";
           print_r($this->request);
           echo "</pre>";

       }

        return view('add');

    }
}
