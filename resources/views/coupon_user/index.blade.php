@extends('layouts.app', ['activePage' => 'coupon_user', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.emp") }}</h4>
                                	
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/coupon_user/create">{{ __("jamia.cr_emp") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.username")}}</th>
                                        <th>{{__("jamia.email")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
                                        <th>{{__("jamia.share")}}</th>
                                        <th>{{__("jamia.status")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($users as $user)
                                            <tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->shareholder_no }}</td>
                                                <td>{{ $user->action }}</td>
												<td>
													<a  href="/coupon_user/{{$user->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>	
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
          if(confirm("Do you want to delete this Employee?") == true){

            var url = '/coupon_user/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
