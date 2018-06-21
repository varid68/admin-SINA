<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class HitungIpkController extends Controller
{
  public function index(Request $request) {
    $key = $request->session()->get('key');

    $result = Curl::to('https://chylaceous-thin.000webhostapp.com/public/counter/?key='.$key)
		->asJson()
    ->get();
    
    return view('content.validasiipk', compact('result'));
  }


  public function hitung(Request $request, $semester) {
    $key = $request->session()->get('key');
    $_semester = urlencode($semester);
    $col = $this->convertSemesteToNumber($semester);
    $nim = [];
    $list = [];

    $_mahasiswa = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/?key='.$key.'&semester='.$_semester.'&jurusan=general')
		->asJson()
		->get();
    
    $mahasiswa = json_decode(json_encode($_mahasiswa), true);

    foreach ((array)$mahasiswa as $item) {
      array_push($nim, $item['nim']);
    }

    $ips = Curl::to('https://chylaceous-thin.000webhostapp.com/public/fetch-ips/?key='.$key)
    ->withData($nim)
    ->asJson()
    ->post();

    foreach ($ips as $key => $value) {
      $list[$key] = [];
      $list[$key]['ip'] = [];
      $x = 0;
      foreach ($value as $value2) {
        foreach ($value2 as $value3) {
          $list[$key]['nama'] = $value3->nama;
          $list[$key]['ip'][$value3->semester] = $value3->ip;
          $total = $value3->ip + $x;
          $x = $total;
        }
      }
      $list[$key]['total'] = $total;
    }

    return view('content.hitungipk', compact('semester', 'col', 'list'));
  }
  

  public function actionController(Request $request) {
    $request->input('action') == 'entry' ? $this->entry($request) : $this->edit($request);
    return redirect('/validasi');
  }


  public function entry($request) {
    $key = $request->session()->get('key');
    $input = $request->input();
    unset($input['_token']);

    $response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/entryipk/?key='.$key)
    ->withData($input)
    ->post();
  }


  public function edit($request) {
    $key = $request->session()->get('key');
    $input = $request->input();
    unset($input['_token']);

    $response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/editipk/?key='.$key)
    ->withData($input)
    ->post();
  }

  
  protected function convertSemesteToNumber($semester) {
    $col = 0;
    switch ($semester) {
      case 'I': $col = 1;
        break;
      
      case 'II': $col = 2;
        break;
        
      case 'Akselerasi I': $col = 3;
        break;
        
      case 'III': $col = 4;
        break;
        
      case 'IV': $col = 5;
        break;
      
      default: $col = 6;
        break;
    }
    return $col;
  }

}
