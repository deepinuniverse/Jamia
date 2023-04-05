@extends('layouts.app', ['activePage' => 'gallery', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.gallery")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/galleries"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/galleries" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="nm" name="name"  class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="g_date" name="g_date"  class="form-control" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.status")}}</label>
                                        <select class="form-control" name="status" required id="status" >
                                        <option value='0'>--Select--</option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="images[]" multiple>
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
