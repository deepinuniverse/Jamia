@extends('layouts.app', ['activePage' => 'informations', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.information")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/informations"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/informations/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <input type="hidden" name="information_id" value="{{$information->id}}">
                                        <label for="name">{{ __("jamia.description")}}</label>
                                        <textarea class="form-control" id="description" name="description" >{{$information->title}}</textarea>
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
