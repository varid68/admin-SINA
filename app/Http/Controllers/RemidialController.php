<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use PDF;

class RemidialController extends Controller
{
	public function index(Request $request) {
		$key = $request->session()->get('key');
		$semester = $request->session()->get('semester');
		$id_matkul = $request->session()->get('id');

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
				if ($item->nim == $value->nim) {
					$push = ["nim" => $item->nim, "nama" => $item->nama, "absensi" => $value->absensi, "tugas" => $value->tugas, 
									"uts" => $value->uts, "uas" => $value->uas, "nilai_akhir" => $value->nilai_akhir, "grade" => $this->grade($value->nilai_akhir)]; 
					array_push($list, $push);
				}
				if ($item->nim != $value->nim) $counter++;
						
				if ($counter == count($nilai)) {
					$new = ["nim" => $item->nim, "nama" => $item->nama, "absensi" => 0, "tugas" => 0, "uts" => 0,
								"uas" => 0, "nilai_akhir" => 0, "grade" => "D"];
					array_push($list, $new);
				}
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


	public function grade($nilai) {
		$grade = NULL;

    if ($nilai <= 100 && $nilai >= 92) $grade = 'A';
    else if ($nilai <= 91 && $nilai >= 84) $grade = 'A-';      
    else if ($nilai <= 83 && $nilai >= 75) $grade = 'B+';
    else if ($nilai <= 74 && $nilai >= 67) $grade = 'B';
    else if ($nilai <= 66 && $nilai >= 59) $grade = 'B-';      
    else if ($nilai <= 58 && $nilai >= 50) $grade = 'C+';      
    else if ($nilai <= 49 && $nilai >= 42) $grade = 'C';      
    else if ($nilai <= 41 && $nilai >= 34) $grade = 'C';      
    else if ($nilai <= 33 && $nilai >= 25) $grade = 'D+';      
		else if ($nilai <= 24) $grade = 'D';
		
		return $grade;
	}
}
