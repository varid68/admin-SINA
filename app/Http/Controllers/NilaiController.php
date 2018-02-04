<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NilaiController extends Controller
{
  public function index() {
		return view('content.nilai');
	}
}
