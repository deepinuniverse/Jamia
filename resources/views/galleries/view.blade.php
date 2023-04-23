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
                                <a class="btn btn-success" href="/galleries"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                               </div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										
                                        <tr>
                                            <th>{{__("jamia.name")}} : {{ $gallery->title }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__("jamia.date")}} : {{ date('d/m/Y',strtotime($gallery->date))}}</th>
                                        </tr>
                                        <tr><th>{{__("jamia.status")}} : {{ $gallery->status }}</th>
                                        </tr>
									    @if($galley_pics != " ")
										
                                        
                                        @foreach ($galley_pics as $pic)
                                        <tr>
                                            <th><img width="175" height="175"  src="{{$pic->photo}}" alt="image" class="g_img" ></th></tr>
                                        @endforeach
                                        
										
                                        @endif
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
