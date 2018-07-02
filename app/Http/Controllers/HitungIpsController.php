<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use Carbon\Carbon;

class HitungIpsController extends Controller
{
  public function index(Request $request) {
    $key = $request->session()->get('key');    
    
    $result = Curl::to('https://chylaceous-thin.000webhostapp.com/public/schedule-hitungips/?key='.$key)
			->asJson()
      ->get();
    
    $semester = ['I', 'II', 'Akselerasi I', 'III', 'IV', 'Akselerasi II'];

    $mi = [];
    $ka = [];

    foreach ((array) $semester as $value) {
      $mi["$value"] = [];
      foreach ((array) $result->mi as $item) {
        if ($item->semester == $value) {
          $new = [
            'matkul' => $item->mata_kuliah,
            'nama' => $this->getPureName($item->nama),
            'sudah_input' => $item->sudah_input,
          ];
          array_push($mi["$value"], $new);
        }
      }
    }

    foreach ((array) $semester as $value) {
      $ka["$value"] = [];
      foreach ((array) $result->ka as $item) {
        if ($item->semester == $value) {
          $new = [
            'matkul' => $item->mata_kuliah,
            'nama' => $this->getPureName($item->nama),
            'sudah_input' => $item->sudah_input,
          ];
          array_push($ka["$value"], $new);
        }
      }
    }

    return view('content.tampil-schedule', compact('mi', 'ka'));
  }


  public function hitung(Request $request, $semester, $jurusan) {
    $key = $request->session()->get('key');
    $request->session()->put('selectedSemester', $semester);
    $request->session()->put('selectedJurusan', $jurusan);
    $_semester = urlencode($semester);
    $_jurusan = urlencode($jurusan);
    
    $_mahasiswa = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key.'&semester='.$_semester.'&jurusan='.$_jurusan)
		->asJson()
    ->get();
    
    $validasi = Curl::to('https://chylaceous-thin.000webhostapp.com/public/validasi-ips/'.$_semester.'?key='.$key)
		->asJson()
    ->get();
    
    $mahasiswa = json_decode(json_encode($_mahasiswa), true);
    $nim = [];

    foreach ((array)$mahasiswa as $item) {
      array_push($nim, $item['nim']);
    }
    $nilai = Curl::to('https://chylaceous-thin.000webhostapp.com/public/nilai-hitungips/?key='.$key.'&semester='.$_semester)
    ->withData($nim)
    ->asJson()
    ->post();
    
    $list = [];
    
    foreach ((array)$mahasiswa as $value) {
      $x = 0;
      $list[$value['nim']]['data'] = [];
      $list[$value['nim']]['nama'] = $value['nama'];
      $list[$value['nim']]['total_sks'] = $this->hitung_total_sks($nilai);
      foreach ((array) $nilai as $key => $item) {
        if ($value['nim'] == $key) {
          foreach ((array) $item as $key2 => $item2) {
            foreach ($item2 as $item3) {
              $push = [
                'matkul' => $item3->mata_kuliah,
                'sks' =>  $item3->sks,
                'skala_nilai' => $this->skala_nilai($item3->nilai_akhir),
                'bobot_nilai' => $this->bobot_nilai($item3->nilai_akhir),
                'mutu' => $item3->sks * $this->bobot_nilai($item3->nilai_akhir),
              ];
              array_push($list[$value['nim']]['data'], $push);
                
              $total = $item3->sks * $this->bobot_nilai($item3->nilai_akhir) + $x;
              $x = $total;
            }
          }
          $list[$value['nim']]['total_mutu'] = $total;
        }
      }
    }
    
    $request->session()->put('ip', $list);
    return view('content.hitungips', compact('list', 'semester', 'validasi'));

  }


  public function actionController(Request $request) {
    $request->input('action') == 'entry' ? $this->entry($request) : $this->edit($request);
    return redirect('/tampilschedule');
  }


  public function entry($request) {
    $key = $request->session()->get('key');
    $semester = $request->session()->get('selectedSemester');
    $input = $request->input();
    unset($input['_token']);

    $response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/entryips/'.$semester.'/?key='.$key)
    ->withData($input)
    ->post();
  }


  public function edit($request) {
    $key = $request->session()->get('key');
    $input = $request->input();
    $data['ips'] = $input;

    $jurusan = $request->session()->get('selectedJurusan');
    $semester = $request->session()->get('selectedSemester');
    $_jurusan = urlencode($jurusan);
    $_semester = urlencode($semester);
    
    $data['timeline']['content'] = 'IPS mahasiswa jurusan '.$jurusan.' semester '.$semester.' telah diupdate, Silahkan Update kembali IPK Mahasiswa';
		$data['timeline']['updated_at'] = Carbon::now('Asia/Jakarta')->toDateTimeString();
    unset($data['ips']['_token']);
    unset($data['ips']['action']);
    
    $response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/editips/?key='.$key.'&semester='.$_semester.'&jurusan='.$_jurusan)
    ->withData($data)
    ->post();
  }


  public function ajax(Request $request, $nim) {
    $sesi = $request->session()->get('ip');
    $new = [];

    foreach ($sesi as $key => $value) {
      if ($key == $nim) $new = $value;
    }
    return response()->json($new);
  }


  protected function skala_nilai($nilai) {
    $skala = null;
    if ($nilai <= 100 && $nilai >= 85) $skala = 'A';
    else if ($nilai <= 84 && $nilai >= 80) $skala = 'A-';
    else if ($nilai <= 79 && $nilai >= 75) $skala = 'B+';
    else if ($nilai <= 74 && $nilai >= 70) $skala = 'B';
    else if ($nilai <= 69 && $nilai >= 65) $skala = 'B-';
    else if ($nilai <= 64 && $nilai >= 60) $skala = 'C+';
    else if ($nilai <= 59 && $nilai >= 55) $skala = 'C';
    else if ($nilai <= 54 && $nilai >= 50) $skala = 'C-';
    else if ($nilai <= 50 && $nilai >= 40) $skala = 'D';
    else if ($nilai <= 39) $skala = 'E';
    return $skala;
  }


  protected function bobot_nilai($nilai) {
    $bobot = null;
    if ($nilai <= 100 && $nilai >= 85) $bobot = 4.00;
    else if ($nilai <= 84 && $nilai >= 80) $bobot = 3.75;
    else if ($nilai <= 79 && $nilai >= 75) $bobot = 3.50;
    else if ($nilai <= 74 && $nilai >= 70) $bobot = 3.00;
    else if ($nilai <= 69 && $nilai >= 65) $bobot = 2.75;
    else if ($nilai <= 64 && $nilai >= 60) $bobot = 2.50;
    else if ($nilai <= 59 && $nilai >= 55) $bobot = 2.00;
    else if ($nilai <= 54 && $nilai >= 50) $bobot = 1.75;
    else if ($nilai <= 50 && $nilai >= 40) $bobot = 1.50;
    else if ($nilai <= 39) $bobot = 1.00;
    return $bobot;
  }
  

  protected function hitung_total_sks($array) {
    $x = 0;
    foreach ((array) $array as $value) {
      foreach ((array) $value as $item) {
        foreach ((array) $item as $item2) {
          $total = $item2->sks + $x;
          $x = $total;
        }
      }
      break;
    }
    return $total;
  }


  protected function getPureName($nama) {
    $result = explode(",", $nama, 2);
    return $result[0];
  }

}
