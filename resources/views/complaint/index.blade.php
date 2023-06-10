@extends('layouts.app', ['activePage' => 'complaint', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title ">{{ __("jamia.complaint") }}</h4>
                                </div>
                                <div class="hidden-print text-center" id="button">
                                <button class="export_excel btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="data-table complaint_tbl">
                                    <thead class=" text-primary">
                                        <th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.customer")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
                                        <th>{{__("jamia.email")}}</th>
                                        <th>{{__("jamia.reason")}}</th>
                                        <th>{{__("jamia.Complaint_date")}}</th>
                                        <th>{{__("jamia.action") }}</th>
                                               </thead>
                                    <tbody><?php $i=1; ?>
                                          @foreach ($complaints as $complaint)
                    
                                        <tr>
                                          <td>{{ $i++; }}</td>
                                          <td>{{ $complaint->name }}</td>
                                          <td>{{ $complaint->number}}</td>
                                          <td>{{ $complaint->email }}</td>
                                          <td>{{ $complaint->reason }}</td>
                                          <td>{{ $complaint->created_at->format('d-M-Y') }}</td>
                                          <td>
                                           @if($complaint->reason != 'DONE') <button type="button" class="btn btn-warning pending" title={{ __("Action pending") }} data-toggle="modal" data-target="#exampleModal" id="{{$complaint->id}}" >
                                            <i class="fa fa-exclamation-triangle" ></i>
                                            </button>
                                            @endif
                                            <a  href="/complaints/complaintView/{{$complaint->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs" >
                                            <i class="fa fa-eye"></i></a> 
                                            </td>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
<!-- Modal -->
<div class="modal fade complaintModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true">
 
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
        $('.table thead th').eq(5).hide();
        $('.table tbody tr td').eq(5).hide();
        $('.table').tableExport({
          type: 'excel',
          escape: 'false',
          filename: 'complaints.xls',
          exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index', // 'current', 'applied',
                    //'index', 'original'
                    page : 'all', // 'all', 'current'
                    search : 'none' // 'none', 'applied', 'removed'
                },
                columns: [ 1, 2, 3, 4 ]
            }
        }); 
        $('.table thead th').eq(5).show();
        $('.table tbody tr td').eq(5).show();
    });
  });
      
      $(document).on("click",".pending", function() {
         var id = $(this).attr("id"); 
         $('div.complaintModal').empty();
          $.ajax({
            method: 'GET',
            url: '/complaint/pending/view',
            data: { id: id },
            dataType: 'html',
            success: function(result) {
            $('div.complaintModal').append(result);
           },
          });  
         
      });
      $(document).on("click",".admin_reply", function() {
         var status = $(this).attr("id"); 
         var id = $('#complaint_id').val();
         var note = $('textarea#admin_not').val();
          if(note == ''){
            alert("Please Add Admin Explanation");
          }else{
            $.ajax({
            method: 'GET',
            url: '/complaint/doneBy/admin',
            data: { id: id,
                    note:note,
                    status:status  },
            dataType: 'html',
            success: function(result) {
               var url = '/complaints'; 
               window.location= url;
            },
            }); 
          }
      });
      $(document).on("click",".close", function() {
        var modal = document.getElementById('exampleModal');
         modal.style.display = "none";
         var url = '/complaints'; 
         window.location= url;
      });
    </script>
@endsection
