<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class NilaiController extends Controller
{
	public function index(Request $request, $page = 1) {
		$key = $request->session()->get('key');
		$semester = $request->session()->get('semester');
		$offset = ($page -1) * 10;

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key.'&semester='.$semester.'&offset='.$offset)
			->asJson()
			->get();

		$response2 = Curl::to('https://chylaceous-thin.000webhostapp.com/public/count-mahasiswa/?key='.$key.'&semester='.$semester)
			->asJson()
			->get();

		$total = ceil($response2 / 7);
		return view('content.nilai', ['list' => $response, 'total' => $total, 'page' => $page]);
	}

	public function store(Request $request) {
		$input = $request->input();
		unset($input['_token']);
		$id_matkul = $request->session()->get('id');
		$semester = $request->session()->get('semester');
		$key = $request->session()->get('key');
		
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/?key='.$key.'&id='.$id_matkul.'&semester='.$semester)
        ->withData($input)
        // ->asJson()
        ->post();
		dd($response);
	}
}
