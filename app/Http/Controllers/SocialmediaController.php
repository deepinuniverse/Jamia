<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socialmedia;

class SocialmediaController extends Controller
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
            $medias = Socialmedia::all();
            return view('medias.index',['medias'=>$medias]);
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
        return view('medias.create'); 
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
            $media = new Socialmedia();
            $media->instagram = $request['instagram'];
            $media->twitter = $request['twitter'];
            $media->facebook = $request['facebook'];
            $media->linkedin = $request['linkedin'];
            $media->save();
            return redirect('/medias');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $media = Socialmedia::find($id);
         $media->delete();
         return Redirect('/medias')->with('success','Social Media deleted successfully');


    }
}
