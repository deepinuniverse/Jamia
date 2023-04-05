@extends('layouts.app', ['activePage' => 'offer', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.offer") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/offers/create">{{ __("jamia.cre_offer") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.name")}}</th>
                                        <th>{{__("jamia.loc")}}</th>
                                        <th>{{__("jamia.valid")}}</th>
										<th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($offers as $offer)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $offer->topic }}</td>
                                                <td>{{ $offer->location }}</td>
                                                <td>{{ date('d/m/Y',strtotime($offer->from_dt)) }}-{{ date('d/m/Y',strtotime($offer->to_dt)) }}</td>
												<td>
													<img width="75" height="75" src="{{$offer->photo}}" alt="image">
												</td>
												<td>
													<a  href="/offers/{{$offer->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i></a>			<button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$offer->id}}"><i class="fa fa-times"></i></button><a  href="/offers/view/list/{{$offer->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
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
          if(confirm("Do you want to delete this Offer?") == true){

            var url = '/offers/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
