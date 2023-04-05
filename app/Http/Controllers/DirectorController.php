<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Director;

class DirectorController extends Controller
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
            $directors = Director::all();
            return view('directors.index',['directors'=>$directors]);
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
        return view('directors.create'); 
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
            $director = new Director();
            $director->name = $request['d_name'];
            $director->position = $request['position'];
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/directors';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/directors/'.$image_name;
            }
            $director->photo = $img_url;
            $director->save();
            return redirect('/directors');
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
            $director =Director::find($id);
            return view("directors.edit",compact('director'));
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
            $director = Director::find($request->get('director_id'));
            $director->name = $request['d_name'];
            $director->position = $request['position'];
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/directors';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/directors/'.$image_name;
            $director->photo = $img_url;
            }
            $director->save();
        
        return redirect('/directors'); 
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $director = Director::find($id);
         $director->delete();
         return Redirect('/directors')->with('success','News Details deleted successfully');


    }
    public function view()
    {
        //
        try {
            $directors = Director::all();
            return view('directors.view',['directors'=>$directors]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
