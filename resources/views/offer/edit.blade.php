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
                                <h4 class="card-title ">{{ __("jamia.offer")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/offers" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/offers/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="offer_id" value="{{$offer->id}}">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{$offer->topic}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.loc")}}</label>
                                        <input type="text" id="location" name="location"  class="form-control" value="{{$offer->location}}" required>
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.details")}}</label>
                                        <textarea class="form-control" id="details" name="details" >{{$offer->details}}</textarea>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.from")}}</label>
                                        <input type="date" id="from" value="{{$offer->from_dt}}" name="from" class="form-control">
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.to")}}</label>
                                        <input type="date" id="to" value="{{$offer->to_dt}}" name="to" class="form-control">
                                        </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <input type="file" name="img">
                                </div>
                                <div class="col-md-12 p-3">
                                    <input type="submit" value="{{ __("jamia.update") }}" class="btn btn-primary">
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
