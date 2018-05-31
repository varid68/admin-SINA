<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

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
    
    $_mahasiswa = Curl::to("https://chylaceous-thin.000webhostapp.com/public/mahasiswa-hitungips/$semester/$jurusan/?key=$key")
    ->asJson()
    ->get();
    
    $nilai = Curl::to("https://chylaceous-thin.000webhostapp.com/public/nilai-hitungips/$semester/$jurusan/?key=$key")
    ->asJson()
    ->get();
    
    $mahasiswa = json_decode(json_encode($_mahasiswa), true);
    $nilai_converted = $this->array_converter($nilai);
    $list = [];
    
    foreach ((array)$mahasiswa as $value) {
      $x = 0;
      $list[$value['nim']]['data'] = [];
      $list[$value['nim']]['nama'] = $value['nama'];
      $list[$value['nim']]['total_sks'] = $this->hitung_total_sks($nilai_converted);
      foreach ((array) $nilai_converted as $key => $item) {
        if ($value['nim'] == $key) {
          foreach ((array) $item as $key2 => $item2) {
            $push = [
              'matkul' => $item2['matkul'],
              'sks' =>  $item2['sks'],
              'skala_nilai' => $this->skala_nilai($item2['nilai_akhir']),
              'bobot_nilai' => $this->bobot_nilai($item2['nilai_akhir']),
              'mutu' => $item2['sks'] * $this->bobot_nilai($item2['nilai_akhir']),
            ];
            array_push($list[$value['nim']]['data'], $push);

            $total = $item2['sks'] * $this->bobot_nilai($item2['nilai_akhir']) + $x;
            $x = $total;
          }
          $list[$value['nim']]['total_mutu'] = $total;
        }
      }
    }
    $request->session()->put('ip', $list);
    return view('content.hitungips', compact('list'));

  }


  public function entry(Request $request) {
    $key = $request->session()->get('key');
    $semester = $request->session()->get('semester');
    $input = $request->input();
    unset($input['_token']);

    $response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/entriip/'.$semester.'/?key='.$key)
    ->withData($input)
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
    if ($nilai <= 100 && $nilai >= 92) $skala = 'A+';
    else if ($nilai <= 91 && $nilai >= 84) $skala = 'A-';
    else if ($nilai <= 83 && $nilai >= 75) $skala = 'B+';
    else if ($nilai <= 74 && $nilai >= 67) $skala = 'B';
    else if ($nilai <= 66 && $nilai >= 59) $skala = 'B-';
    else if ($nilai <= 58 && $nilai >= 50) $skala = 'C+';
    else if ($nilai <= 49 && $nilai >= 42) $skala = 'C';
    else if ($nilai <= 41 && $nilai >= 34) $skala = 'C-';
    else if ($nilai <= 33 && $nilai >= 25) $skala = 'D+';
    else $skala = 'D';
    return $skala;
  }


  protected function bobot_nilai($nilai) {
    $bobot = null;
    if ($nilai <= 100 && $nilai >= 92) $bobot = 4.00;
    else if ($nilai <= 91 && $nilai >= 84) $bobot = 3.75;
    else if ($nilai <= 83 && $nilai >= 75) $bobot = 3.50;
    else if ($nilai <= 74 && $nilai >= 67) $bobot = 3.00;
    else if ($nilai <= 66 && $nilai >= 59) $bobot = 2.75;
    else if ($nilai <= 58 && $nilai >= 50) $bobot = 2.50;
    else if ($nilai <= 49 && $nilai >= 42) $bobot = 2.00;
    else if ($nilai <= 41 && $nilai >= 34) $bobot = 1.75;
    else if ($nilai <= 33 && $nilai >= 25) $bobot = 1.00;
    else $bobot = 1.00;
    return $bobot;
  }
  

  protected function hitung_total_sks($array) {
    $x = 0;
    foreach ($array as $value) {
      foreach ($value as $item) {
        $total = $item['sks'] + $x;
        $x = $total;
      }
      break;
    }
    return $total;
  }


  protected function getPureName($nama) {
    $result = explode(",", $nama, 2);
    return $result[0];
  }


  protected function array_converter($array) {
    $length = array_count_values(array_column($array, 'nim'));

    $result = [];
    foreach ($length as $key => $value) {
      $result[$key] = [];
      foreach ($array as $item) {
        if ($item->nim == $key) {
          $push = [
            'matkul' => $item->mata_kuliah,
            'nilai_akhir' => $item->nilai_akhir,
            'sks' => $item->sks
          ];
          array_push($result[$key], $push);
        }
      }
    }
    return $result;

  }
}
