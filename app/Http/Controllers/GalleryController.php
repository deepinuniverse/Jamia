<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryPhoto;


class GalleryController extends Controller
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
            $galleries = Gallery::orderBy('title')->get();
            return view('galleries.index',['galleries'=>$galleries]);
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
        return view('galleries.create'); 
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
            $gallery = new Gallery();
            $gallery->title = $request['name'];
            $gallery->date = $request['g_date'];
            $img = $request->file('img');
            if($img != null){
            $image_nameMain  = uniqid().'.'.$img->getClientOriginalExtension();
            $destinationMain = 'storage/Gallery';
            $img->move($destinationMain, $image_nameMain );
            $imge_url = $request->getSchemeAndHttpHost().'/storage/Gallery/'.$image_nameMain;
            $gallery->image = $imge_url;
            }
            $gallery->status = $request['status'];
            $gallery->save();

            if($request->hasFile('images'))
            {
               foreach($request->file('images') as $image)
               {
                 $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                 $destination = 'storage/Gallery';
                 $image->move($destination, $image_name );
                 $img_url = $request->getSchemeAndHttpHost().'/storage/Gallery/'.$image_name; 
                 $g_p = new GalleryPhoto();
                 $g_p->galleries_id = $gallery->id;
                 $g_p->photo = $img_url;
                 $g_p->save();
               } 
            }
            return redirect('/galleries');
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
            $gallery= Gallery::find($id);
            $gal_images = GalleryPhoto::where('galleries_id','=',$id)->get();
            return view("galleries.edit",compact('gallery','gal_images'));
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
        $gallery = Gallery::find($request['gallery_id']);
        $gallery->title = $request['name'];
        $gallery->date = $request['g_date'];
        $img = $request->file('img');
        if($img != null){
            $image_nameMain  = uniqid().'.'.$img->getClientOriginalExtension();
            $destinationMain = 'storage/Gallery';
            $img->move($destinationMain, $image_nameMain );
            $imge_url = $request->getSchemeAndHttpHost().'/storage/Gallery/'.$image_nameMain;
            $gallery->image = $imge_url;
        }
        $gallery->status = $request['status'];
        $gallery->save();

            if($request->hasFile('images'))
            {
               foreach($request->file('images') as $image)
               {
                 $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                 $destination = 'storage/Gallery';
                 $image->move($destination, $image_name );
                 $img_url = $request->getSchemeAndHttpHost().'/storage/Gallery/'.$image_name; 
                 $g_p = new GalleryPhoto();
                 $g_p->galleries_id = $gallery->id;
                 $g_p->photo = $img_url;
                 $g_p->save();
               } 
            }
        return redirect('/galleries');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $gallery = Gallery::find($id);
         $gallery->delete();
         $g_p = GalleryPhoto::where('galleries_id','=',$id)->delete();
         return Redirect('/galleries')->with('success','Gallery deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models
     * @return \Illuminate\Http\Response
     */
    public function destroyPhoto($id)
    {
         $gallery = GalleryPhoto::find($id);
         $gallery->delete();
         return 0;


    }
    public function view($id)
    {
        //
        try {
            $gallery = Gallery::find($id);
            $galley_pics = GalleryPhoto::where('galleries_id','=',$id)->get();
            return view('galleries.view',compact('gallery','galley_pics'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
