<?php


namespace App\Utils;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Helper
{

    /**\
     * @param $keyword
     * @return array
     */
    public static function purifyData($keyword)
    {
        $inTitle = [];
        $inUrl = [];
        $inDescription = [];

        $data = self::fetchGoogleSearch($keyword);
        $inTitleData = self::fetchGoogleSearch($keyword, true);

        $totalResults = $inTitleData->search_information->total_results ?? count($inTitleData->organic_results);
        $results = $data->organic_results;
        foreach ($results as $result) {
            if ($result->title && Str::contains(strtolower($result->title), strtolower($keyword))) {
                $inTitle[] = $result->title;
            }
            if ($result->link && Str::contains(strtolower($result->link), strtolower(str_replace(' ', '-', $keyword)))) {
                $inUrl[] = $result->link;
            }
            if (isset($result->snippet) && Str::contains(strtolower($result->snippet), strtolower($keyword))) {
                $inDescription[] = $result->snippet;
            }
        }
        return ['inTitle' => $inTitle, 'inDescription' => $inDescription, 'inUrl' => $inUrl, 'totalResults' => $totalResults];
    }

    /**
     * @param $keyword
     * @return false|mixed
     */
    public static function fetchGoogleSearch($keyword, $inTitle = false)
    {
        $client = new \GoogleSearch(env('SERP_API'));
        if ($inTitle) {
            $query = ["q" => 'intitle:"' . $keyword . '"'];
        } else {
            $query = ["q" => $keyword];

        }
        return $client->get_json($query);
    }

    /**
     * @param $keyword
     * @return object
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
            ->object();
    }

    /**
     * @param $keyword
     * @return object
     */
    public static function fetchStatsUsingKeywordIo($keyword): object
    {
        $url = sprintf('https://api.keyword.io/related_keywords?api_token=%s&q=%s', env('KWIO_API'), $keyword);
        return Http::get($url)->object();
    }


}

