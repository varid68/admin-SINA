<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use PDF;
use Excel;

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

	public function update(Request $request) {
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

	public function downloadExcel(Request $request) {
		$key = $request->session()->get('key');	
		$list = Curl::to('https://chylaceous-thin.000webhostapp.com/public/alumni/?key='.$key.'&offset=none')
			->asJson()
			->get();

		$data = json_decode(json_encode($list), true);
    $new_data = [];
    
    for ($i=0; $i<count($data); $i++) { 
      $push = ['#' => $i + 1] + $data[$i];
      array_push($new_data, $push);
		}

		return Excel::create('mahasiswa', function($excel) use ($new_data){      
      $excel->sheet('sheet 1', function($sheet) use ($new_data){
				$sheet->fromArray($new_data, null, 'A0', true);
				$sheet->prependRow(['']);
				$sheet->prependRow(2, ['#', 'nim', 'nama', 'judul tugas akhir']);
        $sheet->prependRow(['List alumni amik al-muslim']);

        $sheet->mergeCells('A1:D1');
        $sheet->setWidth(['A' => 5, 'B' => 14, 'C' => 20, 'D' => 35]);

        $sheet->cells('A3:D3', function($cells){
          $cells->setFontWeight('bold');
				});

				$total = count($new_data) + 4;
				$for_nim = 'B4:B'.$total;
				$for_number = 'A4:A'.$total;
				$sheet->cells("$for_nim", function($cells){
          $cells->setAlignment('left');
				});
				$sheet->cells("$for_number", function($cells){
          $cells->setAlignment('left');
        });
        $sheet->cells("A1:D1", function($cells){
          $cells->setAlignment('center');
        });
      });

    })->download('xlsx');
	}
}