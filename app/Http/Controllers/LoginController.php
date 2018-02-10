<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class LoginController extends Controller
{
	public function index(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/login-dosen/')
				->withData( ['username' => $username, 'password' => $password ] )
				->asJson( true )
				->post();
		
		$dosenWithoutTitle = explode(",", $response['auth']['nama'], 2);
		$key = $response['auth']['api_key'];
		$dosen = $response['auth']['nama'];
		$request->session()->put('dosen', $dosen);
		$request->session()->put('dosenWithoutTitle', $dosenWithoutTitle[0]);
		$request->session()->put('key', $key);
		return response()->json($response);
	}
	
	public function setSession(Request $request, $object) {
		$json = json_decode($object);
		$request->session()->put('id', $json->id);
		$request->session()->put('semester', $json->semester);
		return redirect('/news/1');
	}

	public function logout(Request $request) {
		$request->session()->flush();
		return redirect('/');
	}
}

