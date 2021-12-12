<?php


namespace App\Utils;


use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class Helper
{

    /**
     * @param $keyword
     * @return false|mixed
     */
    public static function fetchGoogleSearch($keyword)
    {
        $client = new \GoogleSearch("ea1008b2766e4f46760b50c2850b95f6b5dc5cb4499724d5b13515cbfec3e7ea");
        $query = ["q" => 'Intitle:"'.$keyword.'"'];
        return  $client->get_json($query);
    }
}
