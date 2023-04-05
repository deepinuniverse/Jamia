@extends('layouts.app', ['activePage' => 'branches', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.brch") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/branches/create">{{ __("jamia.cr_branch") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.name")}}</th>
                                        <th>{{__("jamia.branch")}}</th>
                                        <th>{{__("jamia.address")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
										<th>{{__("jamia.hours")}}</th>
                                        <th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($branches as $branche)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $branche->name }}</td>
                                                <td>{{ $branche->branchCategory->name}}</td>
                                                <td>{{ $branche->address }}</td>
                                                <td>{{ $branche->phone}}</td>
                                                <td>{{ $branche->hours}}</td>
												<td>	<img width="75" height="75" src="{{$branche->picture}}" alt="image">
												</td>
												<td>
													<a  href="/branches/{{$branche->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i></a>			<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$branche->id}}"><i class="fa fa-times"></i></button>
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
          if(confirm("Do you want to delete this Branch?") == true){

            var url = '/branches/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
