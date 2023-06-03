<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
            $complaints = Complaint::orderBy('id','desc')->get();
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



        //Temp Deep 



        $title = 'جمعية صباح الناصر التعاونية';
        $notificationType = 'Complaint';

        $ComplaintId = $request->get('id');

      //  echo "<script>console.log('Discard ID:', $discardId);</script>";

       // echo "<span>Discard ID: $discardId</span>";

       // $discardId = 39;
       // $discardId = $request->get('id');
        //$discard = DiscardReport::find($discardId);


        $ComplaintId = $request->get('id');
        $ComplaintData = Complaint::find($ComplaintId);

        $reason = $ComplaintData->reason;
        $notes = $ComplaintData->notes;
        $admin_note = $ComplaintData->admin_note;
        $device_fcm_token = $ComplaintData->device_fcm_token;


    
        if (empty($ComplaintData)) {
            // The $discardReportData is empty
            echo "No discard report found";

        } else {
          
          
            DB::table('fcm_messages')->insert([
                'device_fcm_token' =>  $device_fcm_token,
                'title' =>  $title,
                'notificationType' => $notificationType,
                'reason' => $reason,
                'description' =>  $notes,
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

         // $msg = 'شكرا على تواصلكم ، تم عمل الإجراء اللازم ';
           //$body = $msg . ' : ' . $reason . "\n" . $notes . "\n" . $admin_note;
            $notificationPayload = [
                'to' => $device_fcm_token,
                'notification' => [
                    'title' =>  $title,
                    //'body' => $reason ,
                    'body' =>  $reason . "\n" . $notes . "\n" . $admin_note,
                   // 'body' => $body,
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





         return 0;






      
    }
}
