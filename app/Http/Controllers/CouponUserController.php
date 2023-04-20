<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CouponUser;
use Illuminate\Support\Facades\Hash;

class CouponUserController extends Controller
{
   public function index()
    {
        //
        try {
            $users = CouponUser::all();
            return view('coupon_user.index',['users'=>$users]);
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
        return view('coupon_user.create'); 
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
            if($request->has('ge_reports')){
                $reports = 'Y';
            }else{
                $reports = 'N';
            }
            $user = new CouponUser();
            $user->username = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->password = Hash::make($request['pwd']);
            $user->shareholder_no  = $request['sh_holder'];
            $user->civil_id  = $request['civil'];
            $user->action  = $request['action'];
            $user->generate_reports  = $reports;
            $user->save();
            
           
            return redirect('/coupon_user');
       
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
            $user = CouponUser::find($id);
            return view("coupon_user.edit",compact('user'));
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
            if($request->has('ge_reports')){
                $reports = 'Y';
            }else{
                $reports = 'N';
            }
            $user = CouponUser::find($request->get('user_id'));
            $user->username = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            if($user->password != null){
              $user->password = Hash::make($request['pwd']);  
            }
            $user->shareholder_no  = $request['sh_holder'];
            $user->civil_id  = $request['civil'];
            $user->action  = $request['action'];
            $user->generate_reports  = $reports;
            $user->save();

        return redirect('/coupon_user');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $user = CouponUser::find($id);
         $user->delete();
         return Redirect('/coupon_user')->with('success','User deleted successfully');


    }

}
