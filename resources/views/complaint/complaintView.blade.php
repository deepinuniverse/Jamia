@extends('layouts.app', ['activePage' => 'complaint', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.complaint") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/complaints" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
                               <tr><td>{{ __("jamia.customer")}}: {{$complaint->name}}</td></tr>
                               <tr><td>{{ __("jamia.cust_phone")}}: {{$complaint->number}}</td></tr>
                               <tr><td>{{ __("jamia.email")}}: {{$complaint->email}}</td></tr>
                               <tr><td>{{ __("jamia.reason")}}: {{$complaint->reason}}</td></tr>
                               <tr><td>{{ __("jamia.description")}}: {{$complaint->notes}}</td></tr>
								<tr><td>{{ __("jamia.admin_exp")}}: {{$complaint->admin_note}}</td></tr>	            
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

