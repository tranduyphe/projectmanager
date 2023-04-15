<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DepartmentUser;
use App\Models\Project;
use App\Models\Card;
use App\Models\Tasks;
use App\Models\Label;
use App\Http\Traits\TaskProject;

class TaskController extends Controller
{
    use TaskProject;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user     = Auth::user();
        $user_id  = $user->id;
        $roles    = $user->getRoleNames()->first();
        $users    = User::with('detail_user_department')->find($user_id);
        $cards    = Card::all();
        $labels   = Label::all();
        $results  = [];
        $data     = [];
        $project_id = $request->input('project_id');

        // check admin
        if ($roles == 'administrator') {
            $department_id = $request->input('department_id');
        }else{
            if (!empty($users)) {
                $details = $users->detail_user_department;
                $department_id = $details->department_id;
            }
        }


        foreach ($cards as $key => $card) {            
            $card_id = $card->id;
            $list_tasks = Tasks::where([
                ['card_id', '=', $card_id],
                ['project_id', '=', $project_id],
                ['department_id', '=', $department_id],
            ])->get();
            $list_draggable[$card_id] = [];
            if (!empty($list_tasks)) {
                foreach ($list_tasks as $key => $tasks) {
                    $results[$tasks->id] = $tasks;
                    $list_draggable[$card_id][$key] = $tasks->id;
                    // get list member add in task
                    if (!empty($tasks->list_user_ids)) {
                        $list_tasks[$key]['members'] = $this->listMembers($tasks->list_user_ids);
                    }
                    // get list labels add in task
                    if (!empty($tasks->labels)) {
                        $list_tasks[$key]['task_labels'] = $this->listLabels($tasks->labels);
                    }
                    
                    // get works to do in current task
                    $list_tasks[$key]['works'] = $this->listWorks($tasks->id);

                    // get list files in task
                    $list_tasks[$key]['list_files'] = $this->listFiles($tasks->list_files);
                }
            }

        }

        if (!empty($list_draggable)) {
            $data['list_draggable'] = $list_draggable;
            $data['list_task'] = $results;
        }else{
            $data['list_draggable'] = [];
            $data['list_task'] = [];
        }
        
        
        // get user in project
        $user_project = Project::with('projectuser')->find($project_id);  
        $data['project_users'] = [];
        if (!empty($user_project->projectuser)) { 
            $arr_user = [];      
            foreach ($user_project->projectuser as $key => $user) {
                $arr_user[$user->user_id] = User::find($user->user_id);
            }
            $data['project_users'] = $arr_user;
        }

        // get list user of department
        $data['list_user'] = [];
        $list_user = DepartmentUser::where('department_id', '=', $department_id)->get();
        if (!empty($list_user)) {
            $arr = [];      
            foreach ($list_user as $key => $user) {
                $arr[$user->user_id] = User::find($user->user_id);
            }
            $data['list_user'] = $arr;
        }

        $data['labels'] = $labels;
        $data['cards'] = $cards;

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user       = Auth::user();
        $user_id    = $user->id;
        $roles      = $user->getRoleNames()->first();
        $card_id    = $request->input('card_id');
        $title      = $request->input('title_'.$card_id); 
        $project_id = $request->input('project_id'); 
        $slug       = Str::slug($title);
        if (Tasks::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }
        $users = User::with('detail_user_department')->find($user_id);
        
        if ($roles == 'administrator') {
            $department_id = $request->input('department_id');
        }else{
            if (!empty($users)) {
                $details = $users->detail_user_department;
                $department_id = $details->department_id;
            }
        }
        
        $tasks = new Tasks([
            'title'         => $title,
            'project_id'    => $project_id,
            'card_id'       => $card_id,
            'department_id' => $department_id,
            'slug'          => $slug,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        $tasks->save();
        $tasks = Tasks::find($tasks->id);
        if (!empty($tasks->list_user_ids)) {
            $task['members'] = $this->listMembers($tasks->list_user_ids);
        }
        // get list labels add in task
        if (!empty($tasks->labels)) {
            $tasks['task_labels'] = $this->listLabels($tasks->labels);
        }
        // get works to do in current task
        $tasks['works'] = $this->listWorks($tasks->id);
        // get list files in task
        $tasks['list_files'] = $this->listFiles($tasks->list_files);
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task_id = $request->input('task_id');
        $task = Tasks::find($task_id);
        $id = $this->upLoadFiles($request);
        if ($id) {
            if (!empty($task->list_files)) {
                $files = explode(',',$task->list_files);
                $files[] = $id;
            }else{
                $files = [];
                $files[] = $id;
            }
            $data = array(
                'list_files' => implode(',', $files)
            );
            Tasks::where('id', $task_id)->update($data);
            $task = Tasks::find($task_id);
            $task['list_files'] = $this->listFiles($task->list_files);
        }
        return response()->json($task);
    }

    /**
     * Display the specified resource. 04005224
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = Tasks::findOrFail($id);
        if (!empty($results->list_user_ids)) {
            $results['members'] = $this->listMembers($results->list_user_ids);            
        }
        // get list labels add in task
        if (!empty($results->labels)) {
            $results['task_labels'] = $this->listLabels($results->labels);
        }
        return response()->json($results);     
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
        
        $task_id  = $request->input('task_id');
        $data     = $request->input('info_task');
        if (!empty($data)) {
            Tasks::where('id', $task_id)->update($data);            
        }
        $task = Tasks::find($task_id);
        if (!empty($task->list_user_ids)) {
            $task['members'] = $this->listMembers($task->list_user_ids);
        }
        // get list labels add in task
        if (!empty($task->labels)) {
            $task['task_labels'] = $this->listLabels($task->labels);
        }
        // get works to do in current task
        $task['works'] = $this->listWorks($task->id);
        // get list files in task
        $task['list_files'] = $this->listFiles($task->list_files);
        return response()->json($task);
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
