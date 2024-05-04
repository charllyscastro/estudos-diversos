<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LeafletController extends BaseController
{
    public function index()
    {
        return view('Leaflet/index.php');
    }
}
