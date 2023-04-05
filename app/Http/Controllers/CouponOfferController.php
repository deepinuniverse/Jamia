<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CouponOffer;
use App\Models\OfferCategory;

class CouponOfferController extends Controller
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
            $offers = CouponOffer::orderBy('offer_name')->get();
            return view('coupon_offer.index',['offers'=>$offers]);
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
    	$offer_cat = OfferCategory::orderBy('name')->get();
        return view('coupon_offer.create',compact('offer_cat')); 
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
            $offer = new CouponOffer();
            $offer->offer_name = $request['name'];
            $offer->offer_categories_id = $request['offer_cat'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/Couponoffers';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/Couponoffers/'.$image_name;
            }
            $offer->picture = $img_url;
            $offer->description = $request['details'];
            $offer->from_dt = $request['from'];
            $offer->to_dt = $request['to'];
            $offer->contact_no = $request['contact'];
            $offer->save();
            return redirect('/coupon_offer');
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
            $offer_cat = OfferCategory::orderBy('name')->get();
            $coupon= CouponOffer::find($id);
            return view("coupon_offer.edit",compact('offer_cat','coupon'));
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
        $offer = CouponOffer::find($request->get('coupon_id'));
        $offer->offer_name = $request['name'];
        $offer->offer_categories_id = $request['offer_cat'];
        $img_url = '';
        $img = $request->file('img');
        if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/Couponoffers';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/Couponoffers/'.$image_name;
        }
        $offer->picture = $img_url;
        $offer->description = $request['details'];
        $offer->from_dt = $request['from'];
        $offer->to_dt = $request['to'];
        $offer->contact_no = $request['contact'];
        $offer->save(); 

        return redirect('/coupon_offer');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $offer = CouponOffer::find($id);
         $offer->delete();
         return Redirect('/coupon_offer')->with('success','Coupon Offer deleted successfully');


    }
    public function view($id)
    {
        //
        try {
            $offer = CouponOffer::find($id);
            return view('coupon_offer.view',['offer'=>$offer]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
