<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use PDF;

class RemidialController extends Controller
{
	public function index(Request $request) {
		$key = $request->session()->get('key');
		$semester = urlencode($request->session()->get('semester'));
		$id_matkul = $request->session()->get('id');
		$jurusan = urlencode($request->session()->get('jurusan'));

		$mahasiswa = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key.'&semester='.$semester.'&jurusan='.$jurusan)
			->asJson()
			->get();

		$nilai = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/?key='.$key.'&semester='.$semester.'&id_matkul='.$id_matkul)
			->asJson()
			->get();

		$list = [];

		foreach ((array) $mahasiswa as $item) {
			$counter = 0;
			foreach ((array) $nilai as $value) {
				if ($item->nim == $value->nim) {
					$push = ["nim" => $item->nim, "nama" => $item->nama, "absensi" => $value->absensi, "tugas" => $value->tugas, 
									"uts" => $value->uts, "uas" => $value->uas, "nilai_akhir" => $value->nilai_akhir, "grade" => $this->grade($value->nilai_akhir)]; 
					array_push($list, $push);
				}
				if ($item->nim != $value->nim) $counter++;	
			}
			
			if ($counter == count($nilai)) {
				$new = ["nim" => $item->nim, "nama" => $item->nama, "absensi" => 0, "tugas" => 0, "uts" => 0,
							"uas" => 0, "nilai_akhir" => 0, "grade" => "D"];
				array_push($list, $new);
			}
		}

		$remidial = array_filter($list, function ($var) {
    	return ($var["nilai_akhir"] <= 58);
		});

		$request->session()->put('remidial', json_encode($remidial));
		return view('content.remidial', compact('remidial'));
	}


	public function downloadPdf(Request $request) {
		$matkul = $request->session()->get('id');
		$list = json_decode($request->session()->get('remidial'));
		$pdf = PDF::loadView('pdf.remidialpdf', compact('list', 'matkul'))->setPaper('a4','potrait');
		return $pdf->stream('remidial.pdf');
	}


	public function edit(Request $request) {
		$key = $request->session()->get('key');		
		$data = [
			"nim" => $request->input('nim'),
			"id_matkul" => $request->session()->get('id'),
			"semester" => $request->session()->get('semester'),
			"absensi" => $request->input('absensi'),
			"tugas" => $request->input('tugas'),
			"uts" => $request->input('uts'),
			"uas" => $request->input('uas'),
			"nilai_akhir" => $request->input('nilai_akhir'),
		];

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/edit/?key='.$key)
			->withData($data)
			->asJson(true)
			->post();

		return redirect('/remidial');
	}


	public function grade($nilai) {
		$grade = NULL;

    if ($nilai <= 100 && $nilai >= 85) $grade = 'A';
    else if ($nilai <= 84 && $nilai >= 80) $grade = 'A-';      
    else if ($nilai <= 79 && $nilai >= 75) $grade = 'B+';
    else if ($nilai <= 74 && $nilai >= 70) $grade = 'B';
    else if ($nilai <= 69 && $nilai >= 65) $grade = 'B-';      
    else if ($nilai <= 64 && $nilai >= 60) $grade = 'C+';      
    else if ($nilai <= 59 && $nilai >= 55) $grade = 'C';      
    else if ($nilai <= 54 && $nilai >= 50) $grade = 'C-';      
    else if ($nilai <= 50 && $nilai >= 40) $grade = 'D';      
		else if ($nilai <= 39) $grade = 'E';
		
		return $grade;
	}
}
