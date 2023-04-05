@extends('layouts.app', ['activePage' => 'directors', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.director") }}</h4>
                            	</div>
                            	<div>
                                    <a  href="/directors/view/list" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-eye"></i></a>
                                	<a class="btn btn-success" href="/directors/create">{{ __("jamia.cre_director") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.name")}}</th>
                                        <th>{{__("jamia.posi")}}</th>
										<th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($directors as $director)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $director->name }}</td>
                                                <td>{{ $director->position }}</td>
												<td>
													<img width="75" height="75" src="{{$director->photo}}" alt="image">
												</td>
												<td>
													<a  href="/directors/{{$director->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i></a>			<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$director->id}}"><i class="fa fa-times"></i></button>
                                                     
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
          if(confirm("Do you want to delete this Director?") == true){

            var url = '/directors/delete/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
