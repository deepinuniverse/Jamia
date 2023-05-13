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
                        <form action="/family_card/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="family_id" value="{{$family->id}}">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name" required class="form-control" value="{{$family->FCH_SHR_NAME}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.share")}}</label>
                                        <input type="text" id="sh_holder" name="sh_holder" required class="form-control" value="{{$family->SHR_NO}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.civil")}}</label>
                                        <input type="text" id="civil" name="civil" required class="form-control" value="{{$family->CIVIL_ID}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.code")}}</label>
                                        <input type="text" id="code" name="code" required class="form-control" value="{{$family->CODE}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.card_no")}}</label>
                                        <input type="text" id="card" name="card" required class="form-control" value="{{$family->CARD_NO}}">
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.action")}}</label>
                                        <select class="form-control" name="action" id="action">
                                        <option value="Active" {{($family->action == "Active") ? 'selected' : ''}}>Active</option>
                                        <option value="Block" {{($family->action == "Block") ? 'selected' : ''}}>Block</option>
                                        <option value="Freeze" {{($family->action == "Freeze") ? 'selected' : ''}}>Freeze</option>
                                        <option value="Reject" {{($family->action == "Reject") ? 'selected' : ''}}>Reject</option>
                                        <option value="Inactive" {{($family->action == "Inactive") ? 'selected' : ''}}>Inactive</option>
                                        </select>
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
