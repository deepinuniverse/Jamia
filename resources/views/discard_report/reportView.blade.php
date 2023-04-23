@extends('layouts.app', ['activePage' => 'discardReport', 'titlePage' => __('')])

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.discard") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/discard_report" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          	 <table class="table" id="data-table">
                             <h4>{{ __("jamia.discard") }}</h4>
							 @if(empty($discard->item_photo))
                             @else
                             <tr><td> <img width="375" height="175" src="{{$discard->item_photo}}" alt="image" ></td></tr>
                             @endif
                             <tr><td>{{ __("jamia.item")}}: {{$discard->item_name}}</td></tr>
                             <tr><td>{{ __("jamia.jamia_name")}}: {{$discard->jamia_name}}</td></tr>
                             <tr><td>{{ __("jamia.cust_cont")}}: {{$discard->customer_contact}}</td></tr>
                             <tr><td>{{ __("jamia.rpt_details")}}: {{$discard->customer_note}}</td></tr>
                             <tr><td>{{ __("jamia.admin_exp")}}: {{$discard->admin_note}}</td></tr>
                          		</table>
                        	</div>
                            
                        <a  target="_blank"  class="btn btn-success pull-right no-print" onclick="$('.table').printThis();"><i class="fa fa-print"></i> Print</a>

                    	</div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

@endsection
@section('js')
<script src="{{asset('print/printThis.js')}}"></script>
@endsection
