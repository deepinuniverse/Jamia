<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscardReport;
use Auth;

class DiscardReportController extends Controller
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
           

           if(Auth::user()->role == '4'){
              $reports = DiscardReport::whereIn('status', ['RECEIVED','UNDERPROCESS'])->orderBy('report_dt','desc')->get();  
            }else{
              $reports = DiscardReport::where('status','=','DONE')->orderBy('report_dt','desc')->get();  
            }
            
            return view('discard_report.index',['reports'=>$reports]);
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
        return view('discard_report.create'); 
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
            $discard = new DiscardReport();
            $discard->item_name = $request['item'];
            $discard->customer_contact = $request['contact'];
            $discard->jamia_name = $request['name'];
            $discard->customer_note = $request['cust_not'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/DiscardReport';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/DiscardReport/'.$image_name;
            }
            $discard->item_photo = $img_url;
            $discard->report_dt = $request['date'];
            $discard->admin_note = $request['ad_not'];
            $discard->status = $request['status'];
            $discard->save();
            return redirect('/discard_report');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        try {
            $report =DiscardReport::find($id);
            return view("discard_report.edit",compact('report'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
            $discard = DiscardReport::find($request->get('report_id'));
            $discard->item_name = $request['item'];
            $discard->customer_contact = $request['contact'];
            $discard->jamia_name = $request['name'];
            $discard->customer_note = $request['cust_not'];
            $img_url = '';
            $img = $request->file('img');
            if($img != null){
            $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
            $destination = 'storage/DiscardReport';
            $img->move($destination, $image_name );
            $img_url = $request->getSchemeAndHttpHost().'/storage/DiscardReport/'.$image_name;
            $discard->item_photo = $img_url;
            }
            $discard->report_dt = $request['date'];
            $discard->admin_note = $request['ad_not'];
            $discard->status = $request['status'];
            if($request['status'] == 'SEND'){
            $discard->send_dt = date('Y-m-d');    
            }
            $discard->save();
            return redirect('/discard_report');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $rp = DiscardReport::find($id);
         $rp->delete();
         return Redirect('/discard_report')->with('success','Discard Report deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function sendRpt($id)
    {
         $discard = DiscardReport::find($id);
         $discard->status = 'SEND';
         $discard->send_dt = date('Y-m-d');
         $discard->save();
         return Redirect('/discard_report')->with('success','Discard Report Send successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function pendingRptView(Request $request)
    {
         $discard = DiscardReport::find($request->get('id'));
         
         return view("discard_report.pendingView",compact('discard'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function adminRptRpy(Request $request)
    {
         $discard = DiscardReport::find($request->get('id'));
         $discard->status = $request->get('status');
         $discard->admin_note = $request->get('note');
         $discard->save();
         return 0;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function reportView($id)
    {
         $discard = DiscardReport::find($id);
        return view("discard_report.reportView",compact('discard'));


    }

}
