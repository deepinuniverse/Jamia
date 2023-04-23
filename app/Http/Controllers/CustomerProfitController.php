<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerProfit;

class CustomerProfitController extends Controller
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
            $profits = CustomerProfit::all();
            return view('profit.index',['profits'=>$profits]);
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
        return view('profit.create'); 
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
            $profit = new CustomerProfit();
            $profit->title = $request['title'];
            $profit->save();
            return redirect('/customer_profit');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        try {
            $profit = CustomerProfit::find($id);
            return view("profit.edit",compact('profit'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
            $profit = CustomerProfit::find($request->get('profit_id'));
            $profit->title = $request['title'];
            $profit->save();

        return redirect('/customer_profit');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $profit = CustomerProfit::find($id);
         $profit->delete();
         return Redirect('/customer_profit')->with('success','Profit deleted successfully');
    }
    
     
}
