<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
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
            $complaints = Complaint::orderBy('name')->get();
            return view('complaint.index',['complaints'=>$complaints]);
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
        return view('complaint.create'); 
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
            $complaint = new Complaint();
            $complaint->name = $request['name'];
            $complaint->number = $request['contact'];
            $complaint->email = $request['email'];
            $complaint->reason = $request['reason'];
            $complaint->notes = $request['details'];
            $complaint->save();
            return redirect('/complaints');
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
            $complaint = Complaint::find($id);
            return view("complaint.edit",compact('complaint'));
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
}
