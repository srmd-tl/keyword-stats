<?php

namespace App\Jobs;

use App\Models\KeywordStat;
use App\Utils\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchKeywordStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $keyword;
    private $userId;
    private $projectId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $keyword, int $userId, int $projectId)
    {
        $this->keyword = $keyword;
        $this->userId=$userId;
        $this->projectId=$projectId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //fetch stats from keywrodio api
        $kwStats = Helper::fetchStatsUsingKeywordIo($this->keyword);
        for ($i = 0; $i < 20; $i++) {
            $temp = [];
            if ($kwStats) {
                $kwStatsObj = $kwStats->keywords[$i];
                $vol = $kwStatsObj->n;
                $cpcVal = $kwStatsObj->sb;
                $competition = $kwStatsObj->c;
                $temp['search_volume'] = $vol;
                $temp['cpc'] = $cpcVal;
                $temp['competition'] = $competition;
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
                $temp['kw_in_url'] = count($googleStats['inUrl']);
                $temp['kw_in_title'] = count($googleStats['inTitle']);
                $temp['kw_in_description'] = count($googleStats['inDescription']);
                $temp['difficulty'] = $difficulty;
                $temp['keyword'] = $kwStatsObj->kw;
                $temp['user_id'] = $this->userId;
                $temp['project_id'] = $this->projectId;


                if ($vol > 0) {
                    $temp['ratio'] = $googleStats['totalResults'] / $vol;
                }
                $temp['in_title_url_result'] = $googleStats['totalResults'];
            }
            KeywordStat::firstOrCreate(['keyword' => $kwStatsObj->kw], $temp);
        }
    }
}
