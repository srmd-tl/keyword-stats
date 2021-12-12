<?php


namespace App\Utils;


use Illuminate\Support\Facades\Http;

class Helper
{

    /**
     * @param $keyword
     * @return false|mixed
     */
    public static function fetchGoogleSearch($keyword)
    {
        $client = new \GoogleSearch(env('SERP_API'));
        $query = ["q" => 'Intitle:"' . $keyword . '"'];
        return $client->get_json($query);
    }

    /**
     * @param $keyword
     * @return array|mixed
     */
    public static function fetchStats($keyword)
    {
        return Http::asForm()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => sprintf('%s %s', 'Bearer', env('KWEW_API'))
        ])
            ->post('https://api.keywordseverywhere.com/v1/get_keyword_data', [
                'kw[0]' => $keyword,
            ])
            ->json();
    }

}

