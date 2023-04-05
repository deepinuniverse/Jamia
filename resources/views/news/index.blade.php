@extends('layouts.app', ['activePage' => 'news', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.news_details") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/news/create">{{ __("jamia.create_news_details") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.title")}}</th>
                                        <th>{{__("jamia.date")}}</th>
										<th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($news as $news_details)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $news_details->title }}</td>
                                                <td>{{ date('d-m-Y',strtotime($news_details->date)) }}</td>
												<td>
													<img width="75" height="75" src="{{$news_details->photo}}" alt="image">
												</td>
												<td>
													<a  href="/news/edit/{{$news_details->id}}" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                         <i class="fa fa-edit"></i></a>								
                         <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$news_details->id}}"><i class="fa fa-times"></i></button>
                         <a  href="/news/view/{{$news_details->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
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
          if(confirm("Do you want to delete this News Details?") == true){

            var url = '/news/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
