<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyCardData;
use Picqer\Barcode\BarcodeGeneratorPNG;

class FamilyCardDataController extends Controller
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
            $families = FamilyCardData::all();
            return view('family_card.index',['families'=>$families]);
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
        return view('family_card.create'); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $family = new FamilyCardData();
            $family->NAME = $request['name'];
            $family->SHR_NO = $request['sh_holder'];
            $family->CIVIL_ID  = $request['civil'];
            $family->CODE  = $request['code'];
            $family->CARD_NO  = $request['card'];
            $family->save();
            
           
            return redirect('/family_card');
       
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
            $family = FamilyCardData::find($id);
            return view("family_card.edit",compact('family'));
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
            $family = FamilyCardData::find($request->get('family_id'));
            $family->NAME = $request['name'];
            $family->SHR_NO = $request['sh_holder'];
            $family->CIVIL_ID  = $request['civil'];
            $family->CODE  = $request['code'];
            $family->CARD_NO  = $request['card'];
            $family->save();
            
           
            return redirect('/family_card');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $family = FamilyCardData::find($id);
         $family->delete();
         return Redirect('/family_card')->with('success','User deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function generateBarcodeShow()
    {
        
         $family = FamilyCardData::where('CODE','>',0)->first();
         $generator = new BarcodeGeneratorPNG();
         $barcode = $generator->getBarcode($family->CODE, $generator::TYPE_CODE_128);
         dd($barcode );
         $family_data = FamilyCardData::find($family->id);
         $family_data->barcode = $barcode;
         $family_data->save();
         return redirect('/family_card');
    }
    
}
