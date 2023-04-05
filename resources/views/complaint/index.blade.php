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
                            	<div>
                                	<a class="btn btn-success" href="/complaints/create">{{ __("jamia.cr_complaint") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.customer")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
                                        <th>{{__("jamia.email")}}</th>
                                        <th>{{__("jamia.reason")}}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($complaints as $complaint)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $complaint->name }}</td>
                                                <td>{{ $complaint->number}}</td>
                                                <td>{{ $complaint->email }}</td>
                                                <td>
													{{ $complaint->reason }}
												</td>
												<td>
													<a  href="/complaints/{{$complaint->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i></a>			<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$complaint->id}}"><i class="fa fa-times"></i></button><a  href="/complaints/view/{{$complaint->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs" style="display: none;">
                                                    <i class="fa fa-eye"></i></a> 
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
          if(confirm("Do you want to delete this Coupon Offer?") == true){

            var url = '/coupon_offer/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
