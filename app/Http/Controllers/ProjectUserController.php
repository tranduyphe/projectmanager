<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectUser;
use App\Models\User;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $project_id = $request->input('project_id');
        $user_id = $request->input('user_id');
        $action = $request->input('action');
        if ($action == 'active') {
            $project_user = new ProjectUser([
                'user_id'       => $user_id,
                'project_id'    => $project_id,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            $project_user->save();
            $data = ProjectUser::find($project_user->id); 
            $results = User::find($data->user_id);          
        }else{
            $results = ProjectUser::where([
                ['project_id', '=', $project_id],
                ['user_id', '=', $user_id],
            ])->delete();
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        ProjectUser::destroy($id);
    }
}
