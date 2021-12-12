<?php

namespace App\Http\Controllers;

use App\Utils\Helper;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class KeywordStatController extends BaseVoyagerBaseController
{
    public function store(Request $request)
    {
        //fetch stats from keywordeverywhere api
//        $kwStats = Helper::fetchStats($request->keyword);
        if (false && $kwStats) {
            $kwStats = current($kwStats);
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
            $request->request->add(['kw_in_url' => count($googleStats['inUrl'])]);
            $request->request->add(['kw_in_title' => count($googleStats['inTitle'])]);
            $request->request->add(['kw_in_description' => count($googleStats['inDescription'])]);
            $request->request->add(['cpc' => $cpcVal]);
            $request->request->add(['competition' => $competition]);
        }


    }
}
