@extends('layouts.app', ['activePage' => 'app_users', 'titlePage' => __('')])

@section('content')
    <div class="content">
         
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.mobile_users") }}</h4>
                                	
                            	</div>
                            	<div>
                                {{--  <a class="btn btn-success" href="/coupon_user/create">{{ __("jamia.cr_emp") }}</a>  --}}
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.username")}}</th>
                                        <th>{{__("jamia.civilid")}}</th>
                                        <th>{{__("jamia.email")}}</th>
                                        <th>{{__("jamia.phone")}}</th>
                                        <th>{{__("jamia.box_no")}}</th>
										<th>{{__("jamia.created_at") }}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($appUsers as $user)
                                            <tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->civilid }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->box_no }}</td>
                                                <td>{{ $user->created_at }}</td>

                                                <td>
													         <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$user->id}}">
                                                    <i class="fa fa-times"></i></button>
                                                    
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
          if(confirm("Do you want to delete this User?") == true){

            var url = '/app_users/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
