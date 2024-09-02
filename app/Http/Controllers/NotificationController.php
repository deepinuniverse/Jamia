<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
class NotificationController extends Controller
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
            $notifications = Notification::orderBy('created_dt','DESC')->get();
            return view('notification.index',['notifications'=>$notifications]);
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
        return view('notification.create'); 
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
            $notification = new Notification();
            $notification->notes = $request['description'];
            $notification->created_dt = $request['cr_dt'];
            $notification->save();
            return redirect('/notifications');
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
            $notification = Notification::find($id);
            return view("notification.edit",compact('notification'));
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
        $notification = Notification::find($request->get('notification_id'));
        $notification->notes = $request['description'];
        $notification->created_dt = $request['cr_dt'];
        $notification->save();
        return redirect('/notifications');
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $notification = Notification::find($id);
         $notification->delete();
         return Redirect('/notifications')->with('success','Notification deleted successfully');


    }

    public function SendNotification($id)
    {
        $notify = Notification::where('id',$id)->first();
        
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');
 
        $messaging = $firebase->createMessaging();
 
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => "جمعية صباح الناصر",
                'body' => $notify->notes,
            ],
            'topic' => 'sbahalnasr'
        ]);
 
        $messaging->send($message);
 
        return Redirect('/notifications')->with('success','Notification Send successfully');
    }
}
