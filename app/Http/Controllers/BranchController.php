<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\BranchCategory;

class BranchController extends Controller
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
            $branches = Branch::orderBy('name')->get();
            return view('branch.index',['branches'=>$branches]);
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
        $branchCat = BranchCategory::orderBy('name')->get();
        return view('branch.create',compact('branchCat')); 
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
            $branch = new Branch();
            $branch->name = $request['name'];
            $branch->branch_categories_id = $request['branch_cat'];
            $branch->address = $request['address'];
            $branch->phone = $request['contact'];
            $branch->hours = $request['hour'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/branch';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/branch/'.$image_name;
            }
            $branch->picture = $img_url;
            $branch->location = $request['location'];
            $branch->save();
            return redirect('/branches');
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
            $branch =Branch::find($id);
            $branchCat = BranchCategory::orderBy('name')->get();
            return view("branch.edit",compact('branch','branchCat'));
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
        $branch = Branch::find($request->get('branch_id'));
        $branch->name = $request['name'];
        $branch->branch_categories_id = $request['branch_cat'];
        $branch->address = $request['address'];
        $branch->phone = $request['contact'];
        $branch->hours = $request['hour'];
        $img_url = '';
        $img = $request->file('img');
        if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/branch';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/branch/'.$image_name;
        }
        $branch->picture = $img_url;
        $branch->location = $request['location'];
        $branch->save();
        return redirect('/branches');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $Branch = Branch::find($id);
         $Branch->delete();
         return Redirect('/branches')->with('success','Branch deleted successfully');


    }
}
