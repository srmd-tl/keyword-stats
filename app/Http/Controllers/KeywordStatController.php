<?php

namespace App\Http\Controllers;

use App\Jobs\FetchKeywordStats;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class KeywordStatController extends BaseVoyagerBaseController
{

    public function store(Request $request)
    {
        if (auth()->user()->remaining_keywords <= 0) {
            return back()->withErrors('Limit reached! please recharge the package');
        }
        FetchKeywordStats::dispatch(request()->keyword,auth()->user()->id,request()->project_id);
//        //fetch stats from keywrodio api
//        $kwStats = Helper::fetchStatsUsingKeywordIo(request()->keyword);
//        for ($i = 0; $i < 20; $i++) {
//            $temp = [];
//            if ($kwStats) {
//                $kwStatsObj = $kwStats->keywords[$i];
//                $vol = $kwStatsObj->n;
//                $cpcVal = $kwStatsObj->sb;
//                $competition = $kwStatsObj->c;
//                $temp['search_volume'] = $vol;
//                $temp['cpc'] = $cpcVal;
//                $temp['competition'] = $competition;
//            }
//            //generate Intitle,Inurl etc
//            $googleStats = Helper::purifyData($kwStatsObj->kw);
//            $difficulty = 0;
//            if ($googleStats) {
//                if ($googleStats['totalResults'] >= 0 && $googleStats['totalResults'] <= 10) {
//                    $difficulty = 0;
//                } else if ($googleStats['totalResults'] >= 11 && $googleStats['totalResults'] <= 20) {
//                    $difficulty = 1;
//                } else if ($googleStats['totalResults'] >= 21 && $googleStats['totalResults'] <= 50) {
//                    $difficulty = 2;
//                } else if ($googleStats['totalResults'] >= 51 && $googleStats['totalResults'] <= 100) {
//                    $difficulty = 3;
//                } else if ($googleStats['totalResults'] > 100) {
//                    $difficulty = 4;
//                }
//                $temp['kw_in_url'] = count($googleStats['inUrl']);
//                $temp['kw_in_title'] = count($googleStats['inTitle']);
//                $temp['kw_in_description'] = count($googleStats['inDescription']);
//                $temp['difficulty'] = $difficulty;
//                $temp['keyword'] = $kwStatsObj->kw;
//                $temp['user_id'] = auth()->user()->id;
//                $temp['project_id'] = request()->project_id;
//
//
//                if ($vol > 0) {
//                    $temp['ratio'] = $googleStats['totalResults'] / $vol;
//                }
//                $temp['in_title_url_result'] = $googleStats['totalResults'];
//            }
//            KeywordStat::firstOrCreate(['keyword' => $kwStatsObj->kw], $temp);
//        }

        return redirect()->route('voyager.keyword-stats.index');
    }
}
