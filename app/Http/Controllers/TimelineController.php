<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class TimelineController extends Controller
{
  public function index(Request $request) {
    $key = $request->session()->get('key');

    $result = Curl::to('https://chylaceous-thin.000webhostapp.com/public/timeline/?key='.$key)
		->asJson()
    ->get();

    return view('content.timeline', compact('result'));
  }
}
