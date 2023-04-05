<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $roles = Role::all();
            return view('role.index',['roles'=>$roles]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$permissions = Permission::all();
    	return view('role.create',['permissions'=>$permissions]); 
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
        try {
            $role = new Role();
            $role->name = $request['name'];
            $role->save();
            if($request->get('permisssion') != null)
            {
            	foreach($request->get('permisssion') as $permisssion){
            		$r_p = new RolePermission();
            		$r_p->roles_id = $role->id;
            		$r_p->permissions_id = $permisssion; 
            		$r_p->save();
            	}
            }
            return redirect('/roles');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        try {
        	$role = Role::find($id);
        	$role_permission = RolePermission::where('roles_id','=',$id)
        	                                 ->pluck('permissions_id')->toArray();
        	$permissions = Permission::all();
            return view("role.edit",compact('role','role_permission','permissions'));
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

    public function update(Request $request)
    {
    	$role = Role::find($request->get('role_id'));
        $role->name = $request['name'];
        $role->save();
            if($request->get('permisssion') != null)
            {
            	RolePermission::where('roles_id','=',$role->id)->delete();
            	foreach($request->get('permisssion') as $permisssion){
            		$r_p = new RolePermission();
            		$r_p->roles_id = $role->id;
            		$r_p->permissions_id = $permisssion; 
            		$r_p->save();
            	}
            }   

        return redirect('/roles');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $role = Role::find($id);
         $role->delete();
         RolePermission::where('roles_id','=',$id)->delete();
         return Redirect('/roles')->with('success','Role deleted successfully');


    }
    
}
