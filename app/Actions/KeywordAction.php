<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class KeywordAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Keywords';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.keyword-stats.index',['project'=>$this->data->id]);
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'projects';
    }
}
