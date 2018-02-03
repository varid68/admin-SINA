<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class RemidialController extends Controller
{
	public function index(Request $request) {
		$key = $request->session()->get('key');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key)
			->asJson()
			->get();

		return view('content.remidial', ['list' => $response]);
	}
}
