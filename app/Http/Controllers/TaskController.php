<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Project;
use App\Models\Card;
use App\Models\Tasks;
class TaskController extends Controller
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
        $card_id = $request->input('card_id');
        $title = $request->input('title_'.$card_id); 
        $slug = Str::slug($title, '-');
        $tasks = new Tasks([
            'title' => $title,
            'project_id' => 1,
            'card_id' => $card_id,
            'department_id' => 1,
            'list_user_ids' => "",
            'slug' => $slug,
            'description' => "",
            'dealine' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $tasks->save();
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

        $cards = Card::all();
        $results = [];
        foreach ($cards as $key => $card) {            
            $card_id = $card->id;
            $list_tasks = Tasks::where([
                ['card_id', '=', $card_id],
                ['project_id', '=', $id],
                ['department_id', '=', 1],
            ])->get();
            $results[$card_id] = [];
            $results[$card_id] = $list_tasks;
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
        $card_id = $request->input('card_id');
        $task_id = $request->input('task_id');
        $action  = $request->input('action');
        $tasks = Tasks::find($task_id);
        if ($action == 'move_task') {
            $tasks->card_id = $card_id;
        }
        $tasks->save();
        return response()->json($tasks->save());
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
