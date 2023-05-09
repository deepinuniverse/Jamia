<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\OfferImage;

class OfferController extends Controller
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
            $offers = Offer::all();
            return view('offer.index',['offers'=>$offers]);
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
        return view('offer.create'); 
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
            $offer = new Offer();
            $offer->topic = $request['name'];
            $offer->location = $request['location'];
            $offer->details = $request['details'];
            $offer->from_dt = $request['from'];
            $offer->to_dt = $request['to'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/offers';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/offers/'.$image_name;
            }
            $offer->photo = $img_url;
            $offer->save();
            if($request->hasFile('images'))
            {
               foreach($request->file('images') as $image)
               {
                 $Offer_image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                 $destinations = 'storage/offers';
                 $image->move($destinations, $Offer_image_name );
                 $imges_url = $request->getSchemeAndHttpHost().'/storage/offers/'.$Offer_image_name;

                 $offerImges = new OfferImage();
                 $offerImges->offers_id = $offer->id;
                 $offerImges->image = $imges_url;
                 $offerImges->save();
               }
            }
            return redirect('/offers');
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
            $offer =Offer::find($id);
            $offerImages = OfferImage::where('offers_id','=',$id)->get();
            return view("offer.edit",compact('offer','offerImages'));
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
            $offer = Offer::find($request->get('offer_id'));
            $offer->topic = $request['name'];
            $offer->location = $request['location'];
            $offer->details = $request['details'];
            $offer->from_dt = $request['from'];
            $offer->to_dt = $request['to'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/offers';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/offers/'.$image_name;
            $offer->photo = $img_url;
            }
            $offer->save();
            if($request->hasFile('images'))
            {
               foreach($request->file('images') as $image)
               {
                 $Offer_image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                 $destinations = 'storage/offers';
                 $image->move($destinations, $Offer_image_name );
                 $imges_url = $request->getSchemeAndHttpHost().'/storage/offers/'.$Offer_image_name;

                 $offerImges = new OfferImage();
                 $offerImges->offers_id = $request->get('offer_id');
                 $offerImges->image = $imges_url;
                 $offerImges->save();
               }
            }
            return redirect('/offers');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $offer = Offer::find($id);
         $offer->delete();
         return Redirect('/offers')->with('success','Offer deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
         $offer = Offer::find($id);
         $offerImages = OfferImage::where('offers_id','=',$id)->get();
         return view("offer.view",compact('offer','offerImages'));


    }

    public function destroyImages($id)
    {
         $offer = OfferImage::find($id);
         $offer->delete();
         return Redirect('/offers')->with('success','Offer deleted successfully');


    }
}
