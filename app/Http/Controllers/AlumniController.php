<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use PDF;

class AlumniController extends Controller
{
  public function index(Request $request, $page = 1) {
		$key = $request->session()->get('key');
		$offset = ($page - 1) * 10;

		$list = Curl::to('https://chylaceous-thin.000webhostapp.com/public/alumni/?key='.$key.'&offset='.$offset)
			->asJson()
			->get();

		$response2 = Curl::to('https://chylaceous-thin.000webhostapp.com/public/count-alumni/?key='.$key)
			->asJson()
			->get();

		$total = ceil($response2 / 7);
		return view('content.alumni', compact('list', 'total', 'page'));
	}

	public function store(Request $request) {
		$key = $request->session()->get('key');		
		$input = $request->input();
		$nim = $request->input('nim');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/alumni/'.$nim.'/?key='.$key)
        ->withData($input)
				->post();
				
		$res = json_decode($response);
		if ($res->status == 'success') return redirect('/alumni');
		else dd('gagal menyimpan');
	}

	public function downloadPdf(Request $request) {
		$a = $request->query('start') - 2;
		$b = $request->query('end') - 2;

		if ($a > $b) $start = $request->query('end') - 2;
		else $start = $a;

		if ($b < $a) $end = $request->query('start') - 2;
		else $end = $b;
		
		$jurusan = $request->query('jurusan');
		$key = $request->session()->get('key');

		
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/filter-alumni/?key='.$key.'&start='.$start.'&end='.$end.'&jurusan='.$jurusan)
		->asJson()
		->get();

		$pdf = PDF::loadView('pdf.alumnipdf', compact('start', 'end', 'jurusan', 'response'))->setPaper('a4','landscape');
    return $pdf->stream('list-alumni.pdf');
	}
}