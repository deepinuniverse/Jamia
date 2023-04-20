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
            $complaint = Complaint::find($request->get('complaints_id'));
            $complaint->name = $request['name'];
            $complaint->number = $request['contact'];
            $complaint->email = $request['email'];
            $complaint->reason = $request['reason'];
            $complaint->notes = $request['details'];
            $complaint->save();

        return redirect('/complaints');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $Complaint = Complaint::find($id);
         $Complaint->delete();
         return Redirect('/complaints')->with('success','Complaint deleted successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function complaintView($id)
    {
         $complaint = Complaint::find($id);
        return view("complaint.complaintView",compact('complaint'));


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function pendingView(Request $request)
    {
         $complaint = Complaint::find($request->get('id'));
         return view("complaint.pendingView",compact('complaint'));


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function complaintDone(Request $request)
    {
         $complaint = Complaint::find($request->get('id'));
         $complaint->reason = $request->get('status');
         $complaint->admin_note = $request->get('note');
         $complaint->save();
         return 0;
    }
}
