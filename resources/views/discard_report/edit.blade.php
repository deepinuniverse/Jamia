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
                                <h4 class="card-title ">{{ __("jamia.discard")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/discard_report" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/discard_report/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="report_id" id="report_id" value="{{$report->id}}">
                                <div class="col-md-4 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.item")}}</label>
                                        <input type="text" id="item" name="item"  class="form-control" value="{{$report->item_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="contact" name="contact"  class="form-control" value="{{$report->customer_contact}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.jamia_name")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{$report->jamia_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.status")}}</label>
                                        <select class="form-control" name="status" id="status" required>
                                        <option value='0'>--Select--</option>
                                        <option value="GENERATED" @if($report->status != 0) @if('GENERATED' == $report->status) selected @endif @endif>GENERATED</option>
                                        <option value="SEND" @if($report->status != 0) @if('SEND' == $report->status) selected @endif @endif>SEND</option>
                                        <option value="APPROVED" @if($report->status != 0) @if('APPROVED' == $report->status) selected @endif @endif>APPROVED</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.customer_note")}}</label>
                                        <textarea class="form-control" id="cust_not" name="cust_not" >{{$report->customer_note}}</textarea>

                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.admin_note")}}</label>
                                        <textarea class="form-control" id="ad_not" name="ad_not" >{{$report->admin_note}}</textarea>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="date" value="{{$report->report_dt}}" name="date" class="form-control">
                                        </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <input type="file" name="img">
                                </div>
                                <div class="col-md-12 p-3">
                                    <input type="submit" value="{{ __("jamia.add") }}" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
