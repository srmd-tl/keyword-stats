<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data=\App\Utils\Helper::fetchGoogleSearch('kitchen remodeling');
//    $client = new GoogleSearch("ea1008b2766e4f46760b50c2850b95f6b5dc5cb4499724d5b13515cbfec3e7ea");
//    $query = ["q" => 'Intitle:"kitchen remodeling"'];
//    $response = $client->get_json($query);
    dd($data);
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
