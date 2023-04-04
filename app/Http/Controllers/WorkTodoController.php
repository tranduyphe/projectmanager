<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Traits\TaskProject;
use App\Models\WorkToDo;

class WorkTodoController extends Controller
{
    use TaskProject;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title      = $request->input('title'); 
        $slug       = Str::slug($title);
        $task_id    = $request->input('task_id');
        if (WorkToDo::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }
        
        $todo = new WorkToDo([
            'title'         => $title,
            'task_id'       => $task_id,
            'slug'          => $slug,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        $todo->save();  
        $works = WorkToDo::find($todo->id);
        $works['check_list']  = $this->listWorks($works->id);    
        return response()->json($works);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $works_todo = WorkToDo::find($id);
        $works_todo->checklist()->delete();
        WorkToDo::destroy($id);
    }
}
