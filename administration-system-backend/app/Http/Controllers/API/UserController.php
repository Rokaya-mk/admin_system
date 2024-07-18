<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegister;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',User::class);
        return UserResource::collection(User::paginate(4));
    }
    // search users
    public function searchUser(Request $request){
        $this->authorize('viewAny',User::class);
        $search =$request->search_value;
        if($search){
            $users= User::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orwhere('email','LIKE', "%$search%");
            })->paginate(10);
        }else{
            $users = User::orderBy('created_at', 'desc')->paginate(10);
        }
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegister $request)
    {
        $this->authorize('create',User::class);
        try {
             // user store
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);
            $userData = User::where('email', $user->email)->first();
            $success['name'] = $userData->name;
            $success['email'] = $userData->email;
            return $this->SendResponse($success, 'User stored successfully');
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->SendError('Error',$validator->errors());
        }
        try {
            $user = User::find($id);
            // authorize the action
            $this->authorize('update',$user);
            $user->update($request->all());
            return new UserResource($user);
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
    
        
    }
    public function userProjects(string $id){
        $projects = Project::where('user_id',$id)->paginate(10);
        return response()->json($projects);
        
    }
    public function profile()
    {
        $user = Auth::user();
        return response()->json($user);
    }
    public function updatePassword(Request $request, $id) 
    {
        $request->validate([
            'old_password'          => ['required'],
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ]);
        
        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json(['message'=>'Old Password Doesn\'t match!'],500);
        }   
        User::find($id)->update(['password' => Hash::make($request->password)]);
        return response()->json(['success'=>true,'message'=>'Password updated successfully!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
             // authorize the action
            $this->authorize('delete',$user);
            $user->delete();
            return $this->SendResponse(null,'User is deleted Successfully!');
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
    }
}
