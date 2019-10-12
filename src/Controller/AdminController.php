<?php

namespace Locomotif\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('authgate');
    }
    public function index(){
    	return view('admin::list');
    }
}
