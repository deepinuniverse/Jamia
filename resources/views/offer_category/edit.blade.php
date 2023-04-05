@extends('layouts.app', ['activePage' => 'offerCat', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.offer_cat")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/offer_category"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/offer_category/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <input type="hidden" name="offer_id" value="{{$offer->id}}">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="nm" name="name"  class="form-control" value="{{$offer->name}}" required>
                                    </div>
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
