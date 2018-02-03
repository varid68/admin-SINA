<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use DataTables;
use PDF;

class MahasiswaController extends Controller
{
	public function index(Request $request) {
		return view('content.mahasiswa');
	}
	
	public function datatable(Request $request) {
		$key = $request->session()->get('key');
	
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/all-mahasiswa/?key='.$key)
			->asJson()
			->get();

		if (request()->ajax()) {
			return Datatables::of($response)
				->addIndexColumn()
				->addColumn('jurusan', function($response){
					return 
						"$response->jurusan".'/'."$response->tahun_masuk";
				})
				->addColumn('action',function($response){
          return 
            '<button type="button" class="btn btn-sm btn-success" data-alamat="'.$response->alamat.'" data-toggle="modal" data-target="#modal-default">Detail</button>';
				})->make(true);
		}
	}

	public function downloadPdf(Request $request) {
		$a = $request->query('start');
		$b = $request->query('end');

		if ($a > $b) $start = $request->query('end');
		else $start = $a;

		if ($b < $a) $end = $request->query('start');
		else $end = $b;

		$jurusan = $request->query('jurusan');
		$key = $request->session()->get('key');		

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/filter-mahasiswa/?key='.$key.'&start='.$start.'&end='.$end.'&jurusan='.$jurusan)
			->asJson()
			->get();

		$pdf = PDF::loadView('pdf.mahasiswapdf', compact('start', 'end', 'jurusan', 'response'))->setPaper('a4','landscape');
    return $pdf->stream('list-mahasiswa.pdf');
	}
}
