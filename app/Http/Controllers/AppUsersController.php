<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUsers;

use Illuminate\Support\Facades\DB;

class AppUsersController extends Controller
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
          

            $appUsers = DB::table('appusers')
            ->select('id', 'name', 'phone', 'status', 'email',  'civilid', 'box_no', 'created_at')
            ->get();


          //  return view('app_users.index', compact('appUsers'));
            return view('app_users.index',['appUsers'=>$appUsers]);

           // dd($appUsers);
           // var_dump($appUsers);


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } 

   

   
}
