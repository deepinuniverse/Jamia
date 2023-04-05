<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchCategory;

class BranchCategoryController extends Controller
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
            $branch = BranchCategory::orderBy('name')->get();
            return view('branch_category.index',['branch'=>$branch]);
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
        return view('branch_category.create'); 
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
            $bh_cat = new BranchCategory();
            $bh_cat->name = $request['name'];
            $bh_cat->save();
            return redirect('/branch_category');
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
            $brh =BranchCategory::find($id);
            return view("branch_category.edit",compact('brh'));
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
        $bh_cat = BranchCategory::find($request->get('brh_id'));
        $bh_cat->name = $request['name'];
        $bh_cat->save(); 

        return redirect('/branch_category');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $bh_cat = BranchCategory::find($id);
         $bh_cat->delete();
         return Redirect('/branch_category')->with('success','News Details deleted successfully');


    }
}
