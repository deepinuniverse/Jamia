@extends('layouts.app', ['activePage' => 'profit', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.profit")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/customer_profit"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/customer_profit" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.title")}}</label>
                                        <input type="text" id="title" name="title" required class="form-control">
                                    </div>
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
