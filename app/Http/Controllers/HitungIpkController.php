<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class HitungIpkController extends Controller
{
  public function index(Request $request) {
    $key = $request->session()->get('key');    
    
    $result = Curl::to('https://chylaceous-thin.000webhostapp.com/public/hitung-ipk/?key='.$key)
			->asJson()
      ->get();

    $semester = ['I', 'II', 'Akselerasi I', 'III', 'IV', 'Akselerasi II'];

    $list = [];

    foreach ($semester as $value) {
      $list[$value] = [];
      foreach ($result as $item) {
        if ($value == $item->semester) {
          array_push($list[$value], $item);
        }
      }
    }

    return view('content.hitungipk', compact('list'));
  }
}
