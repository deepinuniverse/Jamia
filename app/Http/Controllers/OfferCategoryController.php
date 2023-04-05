<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferCategory;

class OfferCategoryController extends Controller
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
            $offers = OfferCategory::orderBy('name')->get();
            return view('offer_category.index',['offers'=>$offers]);
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
        return view('offer_category.create'); 
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
            $offer = new OfferCategory();
            $offer->name = $request['name'];
            $offer->save();
            return redirect('/offer_category');
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
            $offer =OfferCategory::find($id);
            return view("offer_category.edit",compact('offer'));
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
        $offer = OfferCategory::find($request->get('offer_id'));
        $offer->name = $request['name'];
        $offer->save(); 

        return redirect('/offer_category');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $offer = OfferCategory::find($id);
         $offer->delete();
         return Redirect('/offer_category')->with('success','Offer Category deleted successfully');


    }
}
