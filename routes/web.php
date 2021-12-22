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
    return redirect()->route('voyager.dashboard');
    $data = "https://www.bhg.com/kitchen/remodeling/planning/kitchen-remodeling/";
    dd(\Illuminate\Support\Str::contains($data,strtolower(str_replace(' ','-','kitchens remodeling'))));
    $response =array (
        'data' =>
            array (
                0 =>
                    array (
                        'vol' => 246000,
                        'cpc' =>
                            array (
                                'currency' => '$',
                                'value' => '3.98',
                            ),
                        'keyword' => 'keyword planner',
                        'competition' => 0.28,
                        'trend' =>
                            array (
                                0 =>
                                    array (
                                        'month' => 'December',
                                        'year' => 2020,
                                        'value' => 246000,
                                    ),
                                1 =>
                                    array (
                                        'month' => 'January',
                                        'year' => 2021,
                                        'value' => 201000,
                                    ),
                                2 =>
                                    array (
                                        'month' => 'February',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                3 =>
                                    array (
                                        'month' => 'March',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                4 =>
                                    array (
                                        'month' => 'April',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                5 =>
                                    array (
                                        'month' => 'May',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                6 =>
                                    array (
                                        'month' => 'June',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                7 =>
                                    array (
                                        'month' => 'July',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                8 =>
                                    array (
                                        'month' => 'August',
                                        'year' => 2021,
                                        'value' => 201000,
                                    ),
                                9 =>
                                    array (
                                        'month' => 'September',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                10 =>
                                    array (
                                        'month' => 'October',
                                        'year' => 2021,
                                        'value' => 246000,
                                    ),
                                11 =>
                                    array (
                                        'month' => 'November',
                                        'year' => 2021,
                                        'value' => 201000,
                                    ),
                            ),
                    ),
            ),
        'credits' => 93560,
        'time' => 0,
    );
    if($response)
    {
        //dd(current($response)[0]['cpc']);
    }
//    $stats = \App\Utils\Helper::fetchStats('keyword planner');
//    dd($stats);

    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
