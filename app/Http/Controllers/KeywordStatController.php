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
        if(auth()->user()->remaining_keywords<=0)
        {
            return back()->withErrors('Limit reached! please recharge the package');
        }
        //fetch stats from keywordeverywhere api
        $kwStats = Helper::fetchStats($request->keyword);
        $difficulty = 0;
        if ($kwStats) {
            $kwStats = current($kwStats->data);
            $vol = $kwStats->vol;
            $cpcVal = $kwStats->cpc->value;
            $competition = $kwStats->competition;
            $request->request->add(['search_volume' => $vol]);
            $request->request->add(['cpc' => $cpcVal]);
            $request->request->add(['competition' => $competition]);
        }
        //generate Intitle,Inurl etc
        $googleStats = Helper::purifyData($request->keyword);
        if ($googleStats) {
            if ($googleStats['totalResults'] <= 5) {
                $difficulty = 0;
            } else if ($googleStats['totalResults'] >= 11 && $googleStats['totalResults'] <= 50) {
                $difficulty = 1;
            } else if ($googleStats['totalResults'] >= 51 && $googleStats['totalResults'] <= 100) {
                $difficulty = 2;
            }
            $request->request->add(['kw_in_url' => count($googleStats['inUrl'])]);
            $request->request->add(['kw_in_title' => count($googleStats['inTitle'])]);
            $request->request->add(['kw_in_description' => count($googleStats['inDescription'])]);
            $request->request->add(['difficulty' => $difficulty]);
            $request->request->add(['ratio' => $googleStats['totalResults'] / $vol]);
            $request->request->add(['in_title_url_result' => $googleStats['totalResults']]);
        }
        KeywordStat::firstOrCreate(['keyword' => $request->keyword], $request->except('_token'));
        return redirect()->route('voyager.keyword-stats.index');
    }
}
