<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use DataTables;
use PDF;

class MahasiswaController extends Controller
{
	public function index(Request $request) {
		$id = $request->session()->get('id');
		$key = $request->session()->get('key');
		$mahasiswa = $request->session()->get('mahasiswa');

		if ($id != 'admin' && $mahasiswa == null) {
			$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/all-mahasiswa/?key='.$key)
				->asJson()
				->get();

			$request->session()->put('mahasiswa', $response);
		}
		return view('content.mahasiswa');
	}

	
	public function datatable(Request $request) {
		$key = $request->session()->get('key');
		$id = $request->session()->get('id');
		
		if ($id != 'admin') {
			$response = $request->session()->get('mahasiswa');
			return Datatables::of($response)
			->addIndexColumn()
			->addColumn('jurusan', function($response){
				return 
				$this->shorter($response->jurusan).'/'."$response->tahun_masuk";
			})
			->addColumn('action',function($response){
          return 
						'<button type="button" class="btn btn-sm btn-success detail" data-alamat="'.$response->alamat.'" data-toggle="modal" data-target="#modal-default">Detail</button>';
				})->make(true);
		} else {
			$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/all-mahasiswa/?key='.$key)
				->asJson()
				->get();

			return Datatables::of($response)
			->addIndexColumn()
			->addColumn('jurusan', function($response){
				return 
				$this->shorter($response->jurusan).'/'."$response->tahun_masuk";
			})
			->addColumn('action',function($response){
          return
						'<button type="button" class="btn btn-sm bg-purple detail" data-alamat="'.$response->alamat.'" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-default">
							<i class="fa fa-info"></i>
						</button>
						<button type="button" class="btn btn-sm btn-info edit" data-alamat="'.$response->alamat.'" title="Klik untuk edit" data-toggle="modal" data-target="#general-modal">
							<i class="fa fa-paint-brush"></i>
						</button>
						<button type="button" class="btn btn-sm btn-danger delete" data-id="'.$response->nim.'" title="Klik untuk hapus">
							<i class="fa fa-trash"></i>
						</button>';
				})->make(true);
		}
	}


	public function shorter($jurusan) {
		$result = $jurusan == 'Manajemen Informatika' ? 'MI' : 'KA';
		return $result;
	}


	public function input(Request $request) {
		$key = $request->session()->get('key');
		$nim = $request->input('nim');
		$nama = $request->input('nama');
		$gender = $request->input('gender');
		$ttl = $request->input('ttl');
		$alamat = $request->input('alamat');
		$jurusan = $request->input('jurusan');
		$tahun_masuk = $request->input('tahun_masuk');
		$semester = $request->input('semester');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa-input/?key='.$key)
			->withData(['nim' => $nim, 'nama' => $nama, 'gender' => $gender, 'ttl' => $ttl, 'alamat' => $alamat, 'jurusan' => $jurusan, 'tahun_masuk' => $tahun_masuk, 'semester' => $semester])
			->asJson(true)
			->post();

		return redirect ('/mahasiswa');
	}


	public function edit (Request $request) {
		$key = $request->session()->get('key');
		$nim = $request->input('nim');
		$nama = $request->input('nama');
		$gender = $request->input('gender');
		$ttl = $request->input('ttl');
		$alamat = $request->input('alamat');
		$jurusan = $request->input('jurusan');
		$tahun_masuk = $request->input('tahun_masuk');
		$semester = $request->input('semester');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/'.$nim.'/?key='.$key)
			->withData(['nama' => $nama, 'gender' => $gender, 'ttl' => $ttl, 'alamat' => $alamat, 'jurusan' => $jurusan, 'tahun_masuk' => $tahun_masuk, 'semester' => $semester])
			->asJson(true)
			->post();

		return redirect ('/mahasiswa');
	}


	public function delete (Request $request, $id) {
		$key = $request->session()->get('key');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/'.$id.'/?key='.$key)
		->asJson()
		->get();

		return redirect ('/mahasiswa');
	}
	

	public function downloadPdf(Request $request) {
		$id = $request->session()->get('id');
		$jurusan = urlencode($request->query('jurusan'));
		$_jurusan = $request->query('jurusan');
		$semester = $request->query('semester');
		$key = $request->session()->get('key');

		if ($id != 'admin') {
			$mahasiswa = $request->session()->get('mahasiswa');
			
			if ($jurusan == 'none' && $semester == 'none') $response = $mahasiswa;
			elseif ($jurusan == 'none' && $semester != 'none') {
				$response = array_filter($mahasiswa, function($e) use ($semester) {
					return ($e->semester == $semester);
				});
			}
			elseif ($semester == 'none' && $jurusan != 'none') {
				$response = array_filter($mahasiswa, function($e) use ($_jurusan) {
					return ($e->jurusan == $_jurusan);
				});
			}
			else {
				$response = array_filter($mahasiswa, function($e) use ($semester, $_jurusan) {
					return ($e->semester == $semester && $e->jurusan == $_jurusan);
				});
			}
			
		} else {
			$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/filter-mahasiswa/?key='.$key.'&semester='.$semester.'&jurusan='.$jurusan)
			->asJson()
			->get();
		}

		$pdf = PDF::loadView('pdf.mahasiswapdf', compact('response'))->setPaper('a4','landscape');
    return $pdf->stream('list-mahasiswa.pdf');
	}
}
