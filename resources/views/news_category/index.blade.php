@extends('layouts.app', ['activePage' => 'news_category', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("news.news_category") }}</h4>
                                	<p class="card-category">{{ __("news.news_quot") }}</p>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/news_category/create">{{ __("news.create_news") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									               <thead class=" text-primary">
										               <th>{{__("news.sl_no")}}</th>
                                   <th>{{__("news.name")}}</th>
										               <th>{{__("news.image")}}</th>
										               <th>{{__("news.action") }}</th>
									               </thead>
									               <tbody><?php $i=1; ?>
										             @foreach ($news_category as $category)
                                  <tr>
												             <td>{{ $i++; }}</td>
                                     <td>{{ $category->name }}</td>
												             <td>
													             <img width="75" height="75" src="{{$category->image}}" alt="image">
												             </td>
												              <td>
													            <a  href="/news_category/{{$category->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                                      <i class="fa fa-edit"></i></a>
                                      <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$category->id}}">
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
          if(confirm("Do you want to delete this News Category?") == true){

            var url = '/news_category/delete/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
