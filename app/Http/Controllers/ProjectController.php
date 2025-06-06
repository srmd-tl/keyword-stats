<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;
use App\Models\Project;
class ProjectController extends BaseVoyagerBaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Project::create(['user_id' => auth()->user()->id, 'name' => $request->name]);
        return redirect()->route('voyager.projects.index');
    }

}
