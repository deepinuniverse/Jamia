@extends('layouts.app', ['activePage' => 'discardReport', 'titlePage' => __('')])

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title no-print">{{ __("jamia.discard") }}</h4>
                            	</div>
                                <div class="hidden-print text-center" id="button">
                                <button class="export_excel btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                                </div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.item")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
                                        <th>{{__("jamia.jamia_name")}}</th>
                                        <th>{{__("jamia.date")}}</th>
                                        <th>{{__("jamia.status")}}</th>
										<th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
                                        <th style="display:none">{{ __("jamia.rpt_details")}}</th>
                                        <th style="display:none">{{ __("jamia.admin_exp")}}</th>
									</thead>
									   <tbody><?php $i=1; ?>
										@foreach ($reports as $report)
                    
										<tr>
										<td>{{ $i++; }}</td>
                                        <td>{{ $report->item_name }}</td>
                                        <td>{{ $report->customer_contact }}</td>
                                        <td>{{ $report->jamia_name }}</td>
                                        <td>{{ date('d-m-Y',strtotime($report->report_dt)) }}</td>
                                        <td>{{$report->status}}
                                                 @if($report->status == 'Generated') 
                                                 <button type="button" class="btn btn-warning pending" title={{ __("Action pending") }} data-toggle="modal" data-target="#exampleModal" id="{{$report->id}}" >
                                                 <i class="fa fa-exclamation-triangle" ></i>
                                                 </button>
                                                 @endif
                                         </td>
										<td>
											 <img width="75" height="75" src="{{$report->item_photo}}" alt="image" >
										</td>
										<td>
                                         <a  href="/discard_report/view/{{$report->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-eye"></i></a> 
                                       </td>
                                       <td style="display:none;">{{$report->customer_note}}</td>
                                       <td style="display:none;">{{$report->admin_note}}</td>
                                 </tr>
										@endforeach
									</tbody>
                          		</table>
                        	</div>
<!-- Modal -->
<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 
</div><!-- Modal -->
                    	</div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

@endsection
@section('js')
<script src="{{asset('export/tableexport-xls-bold-headers.js')}}"></script>
    <script>
      $(document).ready( function () {
          $('#data-table').DataTable();
        } 
      );
    $(document).ready(function(){
    $(".export_excel").click(function(){
        $('.table thead th').eq(8).show();
        $('.table tbody tr td').eq(8).show(); 
        $('.table thead th').eq(9).show();
        $('.table tbody tr td').eq(9).show();
        $('.table thead th').eq(7).hide();
        $('.table tbody tr td').eq(7).hide();
        $('.table thead th').eq(6).hide();
        $('.table tbody tr td').eq(6).hide();
        
        $('.table').tableExport({
          type: 'excel',
          escape: 'false',
          filename: 'discardReport.xls',

        });

        $('.table thead th').eq(6).show();
        $('.table tbody tr td').eq(6).show(); 
        $('.table thead th').eq(7).show();
        $('.table tbody tr td').eq(7).show(); 
        $('.table thead th').eq(8).hide();
        $('.table tbody tr td').eq(8).hide();
        $('.table thead th').eq(9).hide();
        $('.table tbody tr td').eq(9).hide();
    });
  });
      $(document).on("click",".delete", function() {
         var id = $(this).attr("id"); 
          if(confirm("Do you want to delete this Discard Report?") == true){

            var url = '/discard_report/destroy/' + id; 
            window.location= url;
          }
      });
      $(document).on("click",".send", function() {
         var id = $(this).attr("id"); 
          if(confirm("Do you want to Send this Discard Report?") == true){
            var url = '/discard_report/send/' + id; 
            window.location= url;
          }
      });
      $(document).on("click",".pending", function() {
         var id = $(this).attr("id"); 
         
          $.ajax({
            method: 'GET',
            url: '/discard_report/pending/view',
            data: { id: id },
            dataType: 'html',
            success: function(result) {
            $('div.exampleModal').append(result);
           },
          });  
         
      });
      $(document).on("click",".admin_reply", function() {
         var status = $(this).attr("id"); 
         var id = $('#discard_id').val();
         var note = $('textarea#admin_not').val();
          if(note == ''){
            alert("Please Add Admin Explanation");
          }else{
            $.ajax({
            method: 'GET',
            url: '/discard_report/admin/replay',
            data: { id: id,
                    note:note,
                    status:status  },
            dataType: 'html',
            success: function(result) {
               var url = '/discard_report'; 
               window.location= url;
            },
            }); 
          }
      });
       $(document).on("click",".close", function() {
        var modal = document.getElementById('exampleModal');
         modal.style.display = "none";
         var url = '/discard_report'; 
         window.location= url;
      });
     
    </script>
@endsection
