<?php

namespace App\Http\Controllers;

use App\Models\KeywordStat;
use App\Utils\Helper;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class KeywordStatController extends BaseVoyagerBaseController
{
    public function store(Request $request)
    {
        if (auth()->user()->remaining_keywords <= 0) {
            return back()->withErrors('Limit reached! please recharge the package');
        }
        //fetch stats from keywrodio api
        $kwStats = Helper::fetchStatsUsingKeywordIo($request->keyword);
        for ($i = 0; $i < 20; $i++) {
            if ($kwStats) {
                $kwStatsObj = $kwStats->keywords[$i];
                $vol = $kwStatsObj->n;
                $cpcVal = $kwStatsObj->sb;
                $competition = $kwStatsObj->c;
                $request->request->add(['search_volume' => $vol]);
                $request->request->add(['cpc' => $cpcVal]);
                $request->request->add(['competition' => $competition]);
            }
            //generate Intitle,Inurl etc
            $googleStats = Helper::purifyData($kwStatsObj->kw);
            $difficulty = 0;
            if ($googleStats) {
                if ($googleStats['totalResults'] >= 0 && $googleStats['totalResults'] <= 10) {
                    $difficulty = 0;
                } else if ($googleStats['totalResults'] >= 11 && $googleStats['totalResults'] <= 20) {
                    $difficulty = 1;
                } else if ($googleStats['totalResults'] >= 21 && $googleStats['totalResults'] <= 50) {
                    $difficulty = 2;
                } else if ($googleStats['totalResults'] >= 51 && $googleStats['totalResults'] <= 100) {
                    $difficulty = 3;
                } else if ($googleStats['totalResults'] > 100) {
                    $difficulty = 4;
                }
                $request->request->add(['kw_in_url' => count($googleStats['inUrl'])]);
                $request->request->add(['kw_in_title' => count($googleStats['inTitle'])]);
                $request->request->add(['kw_in_description' => count($googleStats['inDescription'])]);
                $request->request->add(['difficulty' => $difficulty]);
                $request->request->add(['keyword' =>  $kwStatsObj->kw]);

                if( $vol >0)
                {
                    $request->request->add(['ratio' => $googleStats['totalResults'] / $vol]);
                }
                $request->request->add(['in_title_url_result' => $googleStats['totalResults']]);
            }
            KeywordStat::firstOrCreate(['keyword' => $kwStatsObj->kw], $request->except('_token'));
        }

        return redirect()->route('voyager.keyword-stats.index');
    }
}
