<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;
use App\Models\Card;
use App\Models\Tasks;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user        = Auth::user();
        $user_id     = $user->id;
        $title       = $request->input('title');
        $description = "";
        if (!empty($request->input('description')) && $request->input('description')!== null) {
            $description = $request->input('description');
        }
        $starttime   = $request->input('start_time');
        $endtime     = $request->input('end_time');
        $slug        = Str::slug($title);
        if (Project::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }
        $data        = array(  
            'user_id'     => $user_id,         
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'start_time'   => date('Y-m-d H:i:s', strtotime($starttime)),
            'end_time'     => date('Y-m-d H:i:s', strtotime($endtime)),
        );
        $project = new Project($data);
        $project->save();
        $results = Project::findOrFail($project->id);
        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user     = Auth::user();
        $user_id  = $user->id;
        $roles    = $user->getRoleNames()->first();
        
        if ( $roles === 'administrator' || $roles === 'leader' ) {
            $projects = Project::all();
        } elseif ($roles === 'manager') {
            $user     = User::with('projects')->find($user_id);
            $projects = $user->projects;
        }
        return response()->json($projects);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
