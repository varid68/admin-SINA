<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class LoginController extends Controller
{
	public function index(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/login-dosen/')
				->withData( ['username' => $username, 'password' => $password ] )
				->asJson( true )
				->post();

		$key = $response['auth']['api_key'];
		$nama = $response['auth']['nama'];
		$request->session()->put('dosen', $nama);
		$request->session()->put('key', $key);
		return response()->json($response);
	}
	
	public function setSession(Request $request, $object) {
		$json = json_decode($object);
		$request->session()->put('id', $json->id);
		$request->session()->put('semester', $json->semester);
		return redirect('/nilai');
	}

	public function logout(Request $request) {
		$request->session()->flush();
		return redirect('/');
	}
}

