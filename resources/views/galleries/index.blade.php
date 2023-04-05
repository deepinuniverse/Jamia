@extends('layouts.app', ['activePage' => 'gallery', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.gallery") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/galleries/create">{{ __("jamia.cr_gallery") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.name")}}</th>
                                        <th>{{__("jamia.date")}}</th>
                                        <th>{{__("jamia.status")}}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($galleries as $gallery)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $gallery->title }}</td>
                                                <td>{{ date('d/m/Y',strtotime($gallery->date))}}</td>
                                                <td>{{ $gallery->status }}</td>
                                                <td>
													<a  href="/galleries/{{$gallery->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i></a>			<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$gallery->id}}"><i class="fa fa-times"></i></button><a  href="/galleries/{{$gallery->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
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
          if(confirm("Do you want to delete this Gallery?") == true){

            var url = '/galleries/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
