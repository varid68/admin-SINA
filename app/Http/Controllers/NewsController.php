<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use OneSignal;
use Alert;

class NewsController extends Controller
{
	public function index(Request $request, $page = 1) {
		$key = $request->session()->get('key');
		$offset = ($page - 1) * 7;

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/news-admin/?key='.$key.'&offset='.$offset)
			->asJson()
			->get();

		$response2 = Curl::to('https://chylaceous-thin.000webhostapp.com/public/count-news/?key='.$key)
			->asJson()
			->get();
		
		$total = ceil($response2 / 7);
		return view('content.news', ['list' => $response, 'total' => $total, 'page' => $page ]);
	}


	public function store(Request $request) {
		$key = $request->session()->get('key');
		$image = $request->input('image');
		$image_name = $request->input('image_name');
		$content = $request->input('content');
		$title = $request->input('title');
		$author = $request->input('author');
		$created_at = $request->input('created_at');

		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/news-input/?key='.$key)
			->withData(['image' => $image, 'image_name' => $image_name, 'content' => $content, 'title' => $title, 'author' => $author, 'created_at' => $created_at])
			->asJson(true)
			->post();

		
		$check_length = strlen($title) > 85 ? substr($title,0,85) : $title;
		$notif = preg_replace('/\W\w+\s*(\W*)$/', '$1', $check_length).'...';
		OneSignal::sendNotificationToAll($notif, $url = null, $data = null, $buttons = null, $schedule = null);

		return redirect('/news/1');
	}
	

	public function delete(Request $request, $id) {
		$key = $request->session()->get('key');
		$response = Curl::to('https://chylaceous-thin.000webhostapp.com/public/news/'.$id.'/?key='.$key)
			->get();

		$result = $response == null ? 'gagal' : 'sukses';
		if ($result == 'gagal') {
			Alert::error('berita belum di hapus', 'Gagal!')->autoclose(4000);
		} else {
			Alert::success('berita berhasil di hapus', 'Sukses!')->autoclose(4000);
		}

		return redirect('/news');
	}

}
