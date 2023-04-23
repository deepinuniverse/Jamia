@extends('layouts.app', ['activePage' => 'family_card', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.user") }}</h4>
                               
                            </div>
                            <div>
                                <a class="btn btn-success" href="/family_card"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/family_card" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.share")}}</label>
                                        <input type="text" id="sh_holder" name="sh_holder" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.civil")}}</label>
                                        <input type="text" id="civil" name="civil" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.code")}}</label>
                                        <input type="text" id="code" name="code" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.action")}}</label>
                                        <select class="form-control" name="action" id="action">
                                        <option value="Active">Active</option>
                                        <option value="Block">Block</option>
                                        <option value="Freeze">Freeze</option>
                                        <option value="Reject">Reject</option>
                                        <option value="Inactive">Inactive</option>
                                        </select>
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
