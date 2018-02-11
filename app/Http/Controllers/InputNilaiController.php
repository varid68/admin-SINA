<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class InputNilaiController extends Controller
{
	public function index(Request $request, $page = 1) {
		$key = $request->session()->get('key');
		$semester = $request->session()->get('semester');
		$id_matkul = $request->session()->get('id');
		// $offset = ($page -1) * 10;

		$mahasiswa = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key.'&semester='.$semester.'&offset=none')
			->asJson()
			->get();

		$nilai = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/?key='.$key.'&semester='.$semester.'&id_matkul='.$id_matkul)
			->asJson()
			->get();

		$list = [];

		foreach ((array) $mahasiswa as $item) {
			$counter = 0;
			foreach ((array) $nilai as $value) {
				if ($item->nim != $value->nim) $counter++;
				if ($counter == count($nilai)) array_push($list, $item);
			}
		}

		// $total = ceil($response2 / 7);
		return view('content.inputnilai',compact('list', 'total', 'page'));
	}

	public function store(Request $request) {
		$input = $request->input();
		unset($input['_token']);
		$id_matkul = $request->session()->get('id');
		$semester = $request->session()->get('semester');
		$key = $request->session()->get('key');
		
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/?key='.$key.'&id='.$id_matkul.'&semester='.$semester)
        ->withData($input)
        ->post();
	}
}
