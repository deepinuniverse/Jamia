@extends('layouts.app', ['activePage' => 'news', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.news_details")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/news"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/news/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="news_details_id" value="{{$news->id}}">
                                <div class="col-md-12">
                                    <div class="form-group eng_sh">
                                        <label for="name">{{ __("jamia.title")}}</label>
                                        <input type="text" id="title" name="title" required class="form-control" value="{{$news->title}}">
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.description")}}</label>
                                        <textarea class="form-control" id="description" name="description">{{$news->description}}</textarea>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="date" value="{{$news->date}}" name="date" class="form-control" style="display: inline;">
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
@section('js')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace('description');
</script>
@endsection