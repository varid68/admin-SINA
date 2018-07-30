<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use PDF;
use Alert;
use Carbon\Carbon;

class NilaiController extends Controller
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
					$push = ["nim" => $item->nim, "nama" => $item->nama, "jurusan" => $this->shorter($item->jurusan), "tugas" => $value->tugas, 
					"uts" => $value->uts, "uas" => $value->uas, "nilai_akhir" => $value->nilai_akhir, "grade" => $this->grade($value->nilai_akhir)]; 
					array_push($list, $push);
				}
				if ($item->nim != $value->nim) $counter++;		
			}
			
			if ($counter == count($nilai)) {
				$new = ["nim" => $item->nim, "nama" => $item->nama, "jurusan" => $this->shorter($item->jurusan), "tugas" => 0, "uts" => 0,
				"uas" => 0, "nilai_akhir" => 0, "grade" => "E"];
				array_push($list, $new);
			}
		}
		
		$request->session()->put('nilai', json_encode($list));
		return view('content.nilai', compact('list'));
	}
	
	
	public function edit(Request $request) {
		$input = $request->input();
		$key = $request->session()->get('key');
		$nim = $request->input('nim');
		$id_matkul = $request->session()->get('id');

		$semester = $request->session()->get('semester');
		$jurusan = $request->session()->get('jurusan');
		$mata_kuliah = $request->session()->get('mata_kuliah');
		$dosen = $request->session()->get('dosen');

		unset($input['_token']);
		$input['content'] = 'nilai mata kuliah '.$mata_kuliah.' jurusan '.$jurusan.' semester '.$semester.' telah diupdate oleh '.$dosen.', Silahkan hitung kembali IPS dan IPK';
		$input['updated_at'] = Carbon::now('Asia/Jakarta')->toDateTimeString();
		
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai/edit-nilai/?key='.$key.'&nim='.$nim.'&id_matkul='.$id_matkul)
		->withData($input)
		->post();
		
		$result = $response == null ? 'gagal' : 'sukses';
		if ($result == 'gagal') {
			Alert::error('nilai gagal diupdate', 'Gagal!')->autoclose(2000);
		} else {
			Alert::success('nilai berhasil diupdate', 'Sukses!')->autoclose(2000);
		}
		
    return redirect('/nilai');
	}


	public function downloadPdf(Request $request) {
		$matkul = $request->session()->get('mata_kuliah');
		$nilai = json_decode($request->session()->get('nilai'));
		$pdf = PDF::loadView('pdf.nilaipdf', compact('nilai', 'matkul'))->setPaper('a4','potrait');
		return $pdf->stream('nilai.pdf');
	}


	public function shorter($jurusan) {
		$result = $jurusan == 'Manajemen Informatika' ? 'MI' : 'KA';
		return $result;
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
