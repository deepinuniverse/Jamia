@extends('layouts.app', ['activePage' => 'slideshows', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.slideshows")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/slideshows"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/slideshows/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <input type="hidden" name="slide_id" value="{{$slideshow->id}}">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <textarea class="form-control" id="slideName" name="slideName" required>{{$slideshow->name}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="cr_dt" value="{{$slideshow->created_dt}}" name="cr_dt" class="form-control">
                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="img" >
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
