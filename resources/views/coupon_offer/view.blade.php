@extends('layouts.app', ['activePage' => 'couponoffer', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.coupon_offer") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/coupon_offer" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									
									<tbody>
										
                    
											<tr>
                                                <b>Offer Name : {{ $offer->offer_name }}</b></br>
                                                <b>Offer Category: {{ $offer->offerCategory->name}}</b></br>
												<b>Contact No:{{ $offer->contact_no }}</b></br>
                                                <b>Offer Validity:{{ date('d/m/Y',strtotime($offer->from_dt)) }} to {{ date('d/m/Y',strtotime($offer->to_dt)) }}</b></br>
                                                <img width="175" height="175" src="{{$offer->picture}}" alt="image">
												
												
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

