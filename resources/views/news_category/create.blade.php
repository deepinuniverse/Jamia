@extends('layouts.app', ['activePage' => 'news_category', 'titlePage' => __('')])

@section('content')

    <div class="content">

        <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("news.news_category") }}</h4>
                                <p class="card-category"> {{ __("news.news_cre_quot") }}</p>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/news_category"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/news_category" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __("news.name")}}</label>
                                        <input type="text" id="name" name="name" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="img">
                                </div>
                                <div class="col-md-12 p-3">
                                    <input type="submit" value="{{ __("news.add") }}" class="btn btn-primary">
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

