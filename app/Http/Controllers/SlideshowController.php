<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;

class SlideshowController extends Controller
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
            $slideshows = Slideshow::orderBy('created_dt','DESC')->get();
            return view('slideshows.index',['slideshows'=>$slideshows]);
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
        return view('slideshows.create'); 
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
            $slideshow = new Slideshow();
            $slideshow->name = $request['slideName'];
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/Slideshow';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/Slideshow/'.$image_name;
            }
            $slideshow->image = $img_url;
            $slideshow->created_dt = $request['cr_dt'];
            $slideshow->save();
            return redirect('/slideshows');
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
            $slideshow = Slideshow::find($id);
            return view("slideshows.edit",compact('slideshow'));
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
        $slideshow = Slideshow::find($request->get('slide_id'));
        $slideshow->name = $request['slideName'];
        $img = $request->file('img');
        if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/Slideshow';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/Slideshow/'.$image_name;
            $slideshow->image = $img_url;
        }
        $slideshow->created_dt = $request['cr_dt'];
        $slideshow->save();
        return redirect('/slideshows');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $slideshows = Slideshow::find($id);
         $slideshows->delete();
         return Redirect('/slideshows')->with('success','Slideshows deleted successfully');


    }
}
