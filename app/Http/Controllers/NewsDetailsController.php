<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsDetails;

class NewsDetailsController extends Controller
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
            $news = NewsDetails::all();
            return view('news.index',['news'=>$news]);
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
    	return view('news.create'); 
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
            $news = new NewsDetails();
            $news->title = $request['title'];
            $news->description = $request['description'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/news';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/news/'.$image_name;
            }
            $news->photo = $img_url;
            $news->date = $request['date'];
            $news->save();
            return redirect('/news');
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
        	$news =NewsDetails::find($id);
        	$id = $id;
            return view("news.edit",compact('news','id'));
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
    	$news = NewsDetails::find($request->get('news_details_id'));
    	$news->title = $request['title'];
        $news->description = $request['description'];
        $img = $request->file('img');
        if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/news';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/news/'.$image_name;
            $news->photo = $img_url;
        
        }
        $news->date = $request['date'];
        $news->save();   

        return redirect('/news');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $news = NewsDetails::find($id);
         $news->delete();
         return Redirect('/news')->with('success','News Details deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function ViewNews($id)
    {
         $news = NewsDetails::find($id);
         return view("news.view",compact('news'));


    }
}
