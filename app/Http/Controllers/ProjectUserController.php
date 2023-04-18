<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\Role;
use App\Models\DepartmentUser;
use Illuminate\Support\Facades\Hash;

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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allusers(Request $request)
    {
        $isAdmin = $request->user()->hasAnyRole('administrator');
        
        

        $users = [];
        if($isAdmin){
            $users = User::with(['roles' => function ($query) {
                $query->where('status', 1);
            }])
            ->get()->toArray();
        }else{
            $userId = $request->user()->id;
            $deparmentUser = DepartmentUser::where('user_id', $userId)->get()->first();
            if($deparmentUser){
                $listUser = DepartmentUser::where('department_id', $deparmentUser->department_id)
                ->pluck('user_id')
                ->toArray();
                $users = User::with(['roles' => function ($query) {
                    $query->where('status', 1);
                }])
                ->whereIn('id', $listUser)
                ->get()->toArray();
            }
        }
        
        
        $roles = Role::where('status', 1)->get()->toArray();

        $responseData = [
            'status' => 200,
            'success'=>true,
            'message' => 'success',
            'data' => ['users'=>$users,'roles'=>$roles]
        ];
        return response()->json($responseData);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewUser(Request $request)
    {
        $role = Role::where('id', $request->input('role'))->get()->first();
        $oldUser = User::where('email', $request->input('email'))->get()->first();
        if($oldUser){
            $responseData = [    'status' => 200,'success'=>true,    'message' => 'This account already exists'];
            return response()->json($responseData);
        }
        if ($role){            
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make(""),
                'first_login'=> 1
            ]);
            $user->assignRole($role->name);
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                },
                'roles.permissions' => function ($query) {
                    $query->where('status', 1);
                }
            ]);
            $responseData = [
                'status' => 200,
                'success'=>true,
                'message' => 'The user successfully created',
                'data'=>['user_created'=>$user]
            ];
            return response()->json($responseData);
        }else{
            $responseData = [
                'status' => 200,
                'success'=>false,
                'message' => 'Role not found'
            ];
            return response()->json($responseData);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeRoleUser($id, Request $request)
    {
        $user = User::find($id);
        if($user){
            
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                }
            ]);
            $roles = Role::where('status', 1)->get();
            foreach ($roles as $role) {
                if ($request->has('role_'. $role->id) && $request->input('role_'. $role->id) == true){
                    $user->assignRole($role->name);
                }else{
                    $user->removeRole($role->name);
                }
            }
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                },
            ]);
            $responseData = [
                'status' => 200,
                'success'=>true,
                'message' => 'The user successfully updated',
                'data'=>['user_update'=>$user]
            ];
            return response()->json($responseData);
        }else{
            $responseData = [
                'status' => 200,
                'success'=>true,
                'message' => 'The user not found'
            ];
        return response()->json($responseData);
        }
    }

    // update user
    public function changePasswordUser($id, Request $request)
    {
        $user = User::find($id);
        $password = $request->input('password');
        $repassword = $request->input('repassword');
        if($password !== $repassword or !$password){
            $responseData = ['status' => 200,'success'=>true,    'message' => 'The user false to updated'];
            return response()->json($responseData);
        }
        $user->password = Hash::make($password);
        $user->save();
        $responseData = [
            'status' => 200,'success'=>true,
            'message' =>
            'The user successfully updated'];
        return response()->json($responseData);
    }

    // update user
    public function updateUser( Request $request)
    {
        $user = $request->user();
        $userUpdate = User::find($user->id);
        $userUpdate->last_name = $request->input('last_name');
        $userUpdate->first_name = $request->input('first_name');
        $userUpdate->phone = $request->input('phone');
        $userUpdate->address = $request->input('address');
        $userUpdate->save();
        $responseData = [
            'status' => 200,
            'success'=>true,
            'message' => 'The user successfully updated'];
        return response()->json($responseData);
    }
    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();
        $userUpdate = User::find($user->id);
        // return response()->json($user->password);
        if (!Hash::check($request->input('password'), $user->password)) {
            $responseData = [   'status' => 200,'success'=>true,     'message' => 'Password false'];
            return response()->json($responseData);
            
        }
        $passwordNew = $request->input('password_new');
        $repasswordNew = $request->input('repassword_new');
        if($passwordNew !== $repasswordNew or !$passwordNew){
            $responseData = [   'status' => 200,'success'=>true,     'message' => 'The user false to updated'];
            return response()->json($responseData);
        }
        $user->password = Hash::make($passwordNew);
        $user->save();
        $responseData = [   'status' => 200,'success'=>true,     'message' => 'The user successfully updated'];
        return response()->json($responseData);
    }
}
