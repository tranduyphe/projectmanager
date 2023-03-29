<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Card;
use App\Models\User;
use App\Models\DepartmentUser;


class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = array();
        $user    = Auth::user();
        $user_id = $user->id;
        $cards   = Card::all();      
        $results['cards'] = $cards;
        $users   = User::with('detail_user_department')->find($user_id); 
        
        if (!empty($users->detail_user_department)) {
            $details = $users->detail_user_department;
            $department_id = $details->department_id;
        }else{
            $department_id = 2;
        }
        $results['list_user'] = [];
        $department_user = DepartmentUser::where('department_id',$department_id)->get();
        if (!empty($department_user)) {
            foreach ($department_user as $key => $v) {                
                if ($v->user_id != $user_id) {
                    $info_user = User::find($v->user_id);
                    $results['list_user'][$v->user_id] = $info_user;
                }
            }
        }
        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }
}
