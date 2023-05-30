<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscardReport;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


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
           
            $reports = DiscardReport::orderBy('id','desc')->get();  
            
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

            session()->flash('alert', 'This is an alert message.');

            // Redirect back to the previous page or a specific route
            return redirect()->back();
          
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
        try {
            $discard = DiscardReport::find($request->get('id'));
           // $discardId = $discard->id;
            $discard->status = $request->get('status');
            $discard->admin_note = $request->get('note');
            $discard->save();
    
            //Temp Deep
            $title = 'جمعية صباح الناصر التعاونية';
            $notificationType = 'Disard Report';
    
            $discardId = $request->get('id');

          //  echo "<script>console.log('Discard ID:', $discardId);</script>";

           // echo "<span>Discard ID: $discardId</span>";

           // $discardId = 39;
           // $discardId = $request->get('id');
            //$discard = DiscardReport::find($discardId);


            $discardId = $request->get('id');
            $discardReportData = DiscardReport::find($discardId);

            $item_name = $discardReportData->item_name;
            $customer_note = $discardReportData->customer_note;
            $admin_note = $discardReportData->admin_note;
            $device_fcm_token = $discardReportData->device_fcm_token;


        
            if (empty($discardReportData)) {
                // The $discardReportData is empty
                echo "No discard report found";

            } else {
              
              
                DB::table('fcm_messages')->insert([
                    'device_fcm_token' =>  $device_fcm_token,
                    'title' =>  $title,
                    'notificationType' => $notificationType,
                    'reason' => $item_name,
                    'description' =>  $customer_note,
                    'admin_explanation' => $admin_note 
                ]);


              /*  $insertedId = DB::table('fcm_messages')->insertGetId([
                    'device_fcm_token' =>  $device_fcm_token,
                    'title' =>  $title,
                    'notificationType' => 'Complaint',
                    'reason' => $item_name,
                    'description' =>  $customer_note,
                    'admin_explanation' => $admin_note 
                ]); */

                $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

              //  $device_fcm_token = 'dPW1numVB0HpohbGEjpmiS:APA91bEJhyoK6o1-Q-K1TopMO3sfNINHHpGzRugjws9dwgfyMVmsBM7dF5pRNCQFh_8XYPPFDPr0O8LM9C2tBsM4PQJdoGcSKpBrMMiPu3ExnxkcbDCTDZmOEpJv28LnHuBmUfD8YOnl';

                $notificationPayload = [
                    'to' => $device_fcm_token,
                    'notification' => [
                        'title' =>  $title,
                        //'body' => $reason ,
                        'body' =>$item_name . "\n" . $customer_note . "\n" . $admin_note,
                        //'body' =>'deee',
                    ],
                    'data' => [
                        'key1' => 'value1',
                        'key2' => 'value2',
                       // 'reason' => $reason,
                      //  'notes' => $notes,
                    ],
                ];
                    
                

                // Send the notification to FCM.
                $response = Http::withHeaders([
                    'Authorization' => 'key=' . $serverKey,
                ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);               


            }
       
            
            
          


           
               
              
                

            
            //TEST DEEP CALL FOR Notification
    
           
            //Temp Deep
    
            return 0;
        } catch (\Exception $e) {
            // Handle the exception and show the error on the page
            return $e->getMessage();
        }
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
