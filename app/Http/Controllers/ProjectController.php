<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;
use App\Models\Card;
use App\Models\Tasks;
use App\Models\ProjectUser;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Http\Traits\TaskProject;

class ProjectController extends Controller
{
    use TaskProject;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user     = Auth::user();
        $user_id  = $user->id;
        $roles    = $user->getRoleNames()->first();
        $users    = User::with('detail_user_department')->find($user_id);
        
        if ($roles !== 'manager' && $roles !== 'administrator') {
            if (!empty($users)) {
                $details = $users->detail_user_department;
                $department_id = $details->department_id;
            }else{
                $department_id = 2;
            }
        }
        
        if ( $roles === 'administrator' || $roles === 'leader' ) {
            $projects = Project::all();
        } elseif ($roles === 'manager') {
            $user     = User::with('projects')->find($user_id);
            $projects = $user->projects;
        } else {
            $user     = User::with('projects_user')->find($user_id);
            $project_user = $user->projects_user;
            // // $user_details = ProjectUser::find(20)->details_user;
            // $user_details = ProjectUser::with('details_user')->find(20);
            // var_dump($user_details->details_user);
            $projects = [];
            foreach ($project_user as $key => $project) {
                $projects[] = Project::find($project->project_id);                
            }
        }
        if (!empty($projects)) {
            foreach ($projects as $key => $project) {
                if ($roles === 'leader') {
                    $tasks = Project::with(["tasks" => function($q) use( $department_id ){
                        $q->where('department_id', '=', $department_id);
                    }])->find($project->id);
                }else{
                    $tasks = Project::with('tasks')->find($project->id);
                }
                $projects[$key]['data_task'] = $tasks->tasks;
            }
        }
        return response()->json($projects);
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
        $images = $this->upLoadFiles($request);
        if (!empty($images)) {
            $url_image = $images->name_file;
        }else{
            $url_image = null;
        }
        $data        = array(  
            'user_id'     => $user_id,         
            'title'       => $title,
            'slug'        => $slug,
            'url_image'   => $url_image,
            'description' => $description,
            'start_time'  => date('Y-m-d H:i:s', strtotime($starttime)),
            'end_time'    => date('Y-m-d H:i:s', strtotime($endtime)),
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
        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $slug        = $request->input('slug');
        $project     = Project::with('tasks')->where('slug', $slug)->firstOrFail();
        $departments = Department::with(["tasks" => function($q) use( $project ){
            $q->where('project_id', '=', $project->id);
        }])->get();
        $project['departments'] = $departments;
        return response()->json($project);
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
    public function update(Request $request)
    {
        
        $id = $request->input('id');
        $images = $this->upLoadFiles($request);
        if ( !empty($images) ) {            
            $data['url_image'] = $images->name_file;
            $data['title'] =  $request->input('title');
            $data['description'] =  $request->input('description');
            $data['end_time'] =  $request->input('end_time');
            $data['start_time'] =  $request->input('start_time');
        } else {
            $data = $request->input('data');
        }
        $result = Project::where('id', $id)->update($data);
        return response()->json(Project::find($id));
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
