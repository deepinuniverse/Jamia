<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Role;


class UserController extends Controller
{
    
    public function userIndex()
    {
        //
        try {
            $users = User::all();
            return view('users.userIndex',['users'=>$users]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('users.create',compact('roles')); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {
        //
            if($request->has('ge_reports')){
                $reports = 'Y';
            }else{
                $reports = 'N';
            }
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->role = $request['role'];
            $user->password = Hash::make($request['pwd']);
            $user->shareholder_no  = $request['sh_holder'];
            $user->civil_id  = $request['civil'];
            $user->action  = $request['action'];
            $user->generate_reports  = $reports;
            $user->save();
            
           
            return redirect('/user/list');
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function editUser($id)
    {
       
        try {
            $user = User::find($id);
            $roles = Role::all();
            return view("users.edit",compact('user','roles'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function userUpdate(Request $request)
    {
            if($request->has('ge_reports')){
                $reports = 'Y';
            }else{
                $reports = 'N';
            }
            $user = User::find($request->get('user_id'));
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->role = $request['role'];
            if($user->password != null){
              $user->password = Hash::make($request['pwd']);  
            }
            $user->shareholder_no  = $request['sh_holder'];
            $user->civil_id  = $request['civil'];
            $user->action  = $request['action'];
            $user->generate_reports  = $reports;
            $user->save();

        return redirect('/user/list');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $user = User::find($id);
         $user->delete();
         return Redirect('/user/list')->with('success','User deleted successfully');


    }

    
}
