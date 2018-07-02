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
		
		if ($response != 'Wrong Password') {
			$dosenWithoutTitle = explode(",", $response['auth']['nama'], 2);
			$key = $response['auth']['api_key'];
			$dosen = $response['auth']['nama'];
			$request->session()->put('dosen', $dosen);
			$request->session()->put('dosenWithoutTitle', $dosenWithoutTitle[0]);
			$request->session()->put('key', $key);
			$request->session()->put('gender', $response['auth']['gender']);
		}
		return response()->json($response);
	}

	
	public function setSession(Request $request, $object) {
    $key = $request->session()->get('key');
		$json = json_decode($object);
		$request->session()->put('id', $json->id);
		$request->session()->put('semester', $json->semester);
		$request->session()->put('mata_kuliah', $json->mata_kuliah);

		if ($json->id != 'none') {
			$result = Curl::to('https://chylaceous-thin.000webhostapp.com/public/finder/'.$json->id.'/?key='.$key)
					->asJson()
					->get();
			
			if (count($result) == 1) $request->session()->put('jurusan', $result[0]->jurusan);
			else $request->session()->put('jurusan', 'general');
		}

		$redirect = $json->id == 'admin' ? 'mahasiswa' : 'nilai';
		return redirect("/$redirect");
	}


	public function logout(Request $request) {
		$request->session()->flush();
		return redirect('/');
	}
}
