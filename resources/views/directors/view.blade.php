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
                                <a class="btn btn-success" href="/directors"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									
									<tbody><?php $i=1; ?>
										@foreach ($directors as $director)
                    
											<tr>
												<td>
													<img width="175" height="175" src="{{$director->photo}}" alt="image"><br>
                                                    {{ $director->name }}<br>
                                                    {{ $director->position }}
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

