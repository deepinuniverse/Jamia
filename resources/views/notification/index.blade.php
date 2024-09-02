@extends('layouts.app', ['activePage' => 'notification', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">

       


                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.notification") }}</h4>
                                	
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/notifications/create">{{ __("jamia.cr_notification") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
								  <thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.description")}}</th>
                                        <th>{{__("jamia.date")}}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($notifications as $notification)
                                            <tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $notification->notes }}</td>
                                                <td>{{date('d-m-Y',strtotime($notification->created_dt))}}</td>
                                                <td>
													<a  href="/notifications/{{$notification->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>	
                                                    <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$notification->id}}">
                                                    <i class="fa fa-times"></i></button>
                                                    <!-- 
  <button type="button"  rel="tooltip" title={{ __("save") }} class="btn btn-success btn-simple btn-xs save" id="{{$notification->id}}">
                                                  Save</button>   -->
                                                    
                                                    
                                                   

                                                  <form action="{{route('SendNotification',$notification->id)}}" method="POST">
                                                    @csrf
                                                    <button type="submit"><i class="fa fa-send"></i></button>
                                                 </form>
                                                    
                                                </td>
                                            </tr>
										@endforeach
									</tbody>
                          		</table>
                        	</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
      $(document).ready( function () {
          $('#data-table').DataTable();
        } 
      );
      $(document).on("click",".delete", function() {
         var id = $(this).attr("id"); 
          if(confirm("Do you want to delete this Notification?") == true){

            var url = '/notifications/destroy/' + id; 
            window.location= url;
          }
      });

    
//Send Notification to Devices
$(document).ready(function() {
  $('.send').click(function() {
   // var message = $(this).data('description');
    //var title = 'deepak';
    var id = $(this).attr("id"); 
    // Call your PHP function with the 'description' value
  // alert(id);

   $.ajax({
            url: '{{ route("send-push-notification") }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
               // 'message': message,
               // 'title': title,
                'id':id
            },
            success: function(response) {
                console.log(response); // Handle the response from the server
            },
            error: function(xhr, status, error) {
                console.log(error); // Handle the error
            }
        });


  });
});
</script>





@endsection
