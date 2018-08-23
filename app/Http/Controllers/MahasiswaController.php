<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use DataTables;
use PDF;
use Alert;

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

		$counter = Curl::to('https://chylaceous-thin.000webhostapp.com/public/counter/?key='.$key)
		->asJson()
		->get();
		
		return view('content.mahasiswa', compact('counter'));
	}


	public function academic_board(Request $request, $nim) {
		$isForPdf = $request->get('isForPdf');
		$key = $request->session()->get('key');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/grade-point/'.$nim)
				->asJson()
				->get();

		$mahasiswa = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa/'.$nim.'/?key='.$key)
		->asJson()
    ->get();

		$list = [];
		$semester = ['I', 'II', 'Akselerasi I', 'III', 'IV', 'Akselerasi II'];
		
		foreach ($semester as $value){
			foreach ((array) $response->final_scores as $key => $item){
				if ($value == $item->semester){
					$skala = ['skala' => $this->skala_nilai($item->nilai_akhir)];
					$bobot_nilai = ['bobot_nilai' => $this->bobot_nilai($item->nilai_akhir)];
					$mutu = ['mutu' => $item->sks * $this->bobot_nilai($item->nilai_akhir)];
					$list[$value][] = array_merge((array)$item, (array)$skala, (array)$bobot_nilai, (array)$mutu);
				}
			}
		}
			
		$x = 0;
		foreach ($response->final_scores as $value) {
			$total_sks = $value->sks + $x;
			$x = $total_sks;
		}

		$xx = 0;
		foreach($list as $key => $item){
			foreach($item as $value){
				$total_mutu = $value['mutu'] + $xx;
  	    $xx = $total_mutu;
	    }
		}

		if ($isForPdf == 'true') {
			$pdf = PDF::loadView('pdf.transkripnilai', compact('list', 'mahasiswa','total_mutu', 'total_sks'))->setPaper('f4','potrait');
			return $pdf->stream('transkrip-nilai.pdf');
		} else {
			return view('content.academic-board', compact('list', 'mahasiswa','total_mutu', 'total_sks'));
		}
	}


	public function upgrades(Request $request) {
		$key = $request->session()->get('key');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/up-grades/?key='.$key)
				->asJson()
				->get();
		
		return redirect('/mahasiswa');
	}


	public function downgrades(Request $request) {
		$key = $request->session()->get('key');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/down-grades/?key='.$key)
				->asJson()
				->get();
		
		return redirect('/mahasiswa');
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
						'<a href=academic-board/'.$response->nim.'?isForPdf=false>
							<button type="button" class="btn btn-sm btn-success" title="Klik untuk melihat semua nilai akademik">
								<i class="fa fa-search"></i>
							</button>
						</a>
						<button type="button" class="btn btn-sm btn-success detail" data-alamat="'.$response->alamat.'" data-toggle="modal" data-target="#modal-default">Detail</button>';
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
						'<a href=academic-board/'.$response->nim.'?isForPdf=false>
							<button type="button" class="btn btn-sm btn-success" title="Klik untuk melihat semua nilai akademik">
								<i class="fa fa-search"></i>
							</button>
						</a>
						<button type="button" class="btn btn-sm bg-purple detail" data-alamat="'.$response->alamat.'" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-default">
							<i class="fa fa-info"></i>
						</button>
						<button type="button" class="btn btn-sm bg-purple edit" data-alamat="'.$response->alamat.'" title="Klik untuk edit" data-toggle="modal" data-target="#general-modal">
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
		
		$result = $response == null ? 'gagal' : 'sukses';
		if ($result == 'gagal') {
			Alert::error('data mahasiswa baru belum ditambahkan', 'Gagal!')->autoclose(2000);
		} else {
			Alert::success('data mahasiswa berhasil dientry', 'Sukses!')->autoclose(2000);
		}

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

		$result = $response == null ? 'gagal' : 'sukses';
		if ($result == 'gagal') {
			Alert::error('data mahasiswa belum terupdate', 'Gagal!')->autoclose(2000);
		} else {
			Alert::success('data mahasiswa berhasil diupdate', 'Sukses!')->autoclose(2000);
		}

		return redirect ('/mahasiswa');
	}


	public function delete (Request $request, $id) {
		$key = $request->session()->get('key');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/mahasiswa-delete/'.$id.'/?key='.$key)
		->asJson()
		->post();

		$result = $response == null ? 'gagal' : 'sukses';
		if ($result == 'gagal') {
			Alert::error('data mahasiswa gagal dihapus', 'Gagal!')->autoclose(2000);
		} else {
			Alert::success('data mahasiswa berhasil dihapus', 'Sukses!')->autoclose(2000);
		}

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
	
	
	public function previewPdf(Request $request) {
		$id = $request->session()->get('id');
		$jurusan = urlencode($request->query('jurusan'));
		$_jurusan = $request->query('jurusan');
		$semester = $request->query('semester');
		$key = $request->session()->get('key');
		
		$a = urlencode($semester);
		
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
			$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/filter-mahasiswa/?key='.$key.'&semester='.$a.'&jurusan='.$jurusan)
			->asJson()
			->get();
		}
		
		return view('pdf.preview-pdf', compact('response', 'jurusan', 'a'));
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
}
