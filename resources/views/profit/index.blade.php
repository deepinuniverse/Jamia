@extends('layouts.app', ['activePage' => 'profit', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.profit") }}</h4>
                                	
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/customer_profit/create">{{ __("jamia.cr_profile") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
								  <thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.title")}}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($profits as $profit)
                                            <tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $profit->title }}</td>
                                                <td>
													<a  href="/customer_profit/{{$profit->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>	
                                                    <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$profit->id}}">
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
          if(confirm("Do you want to delete this Customer Profit?") == true){

            var url = '/customer_profit/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
