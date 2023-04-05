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
                                <a class="btn btn-success" href="/offers" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									
									<tbody>
                                            <tr>
                                                <img width="175" height="175" src="{{$offer->photo}}" alt="image"></br>
                                                <b>{{ $offer->details }}</b></br>
                                                <b>{{ $offer->topic }}</b></br>
                                                <b>{{ $offer->location }}</b></br>
                                                <b>{{ date('d/m/Y',strtotime($offer->from_dt)) }}-{{ date('d/m/Y',strtotime($offer->to_dt)) }} </b>
                                             </tr>
										
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

