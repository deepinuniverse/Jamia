@extends('layouts.app', ['activePage' => 'medias', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.social") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/medias/create">{{ __("jamia.cr_social") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.instagram")}}</th>
                                        <th>{{__("jamia.twitter")}}</th>
                                        <th>{{__("jamia.facebook")}}</th>
                                        <th>{{__("jamia.linkedin")}}</th>
                                        <th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($medias as $media)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $media->instagram }}</td>
                                                <td>{{ $media->twitter}}</td>
                                                <td>{{ $media->facebook }}</td>
                                                <td>{{ $media->linkedin }}</td>
												<td>
													<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$media->id}}"><i class="fa fa-times"></i></button> 
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
          if(confirm("Do you want to delete this Details?") == true){

            var url = '/medias/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
