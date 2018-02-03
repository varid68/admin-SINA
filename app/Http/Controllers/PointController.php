<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointController extends Controller
{
  public function index() {
		return view('content.point');
	}
}
