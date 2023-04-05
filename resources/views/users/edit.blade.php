@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('')])

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
                                <a class="btn btn-success" href="/user/list"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/users_list/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name" required class="form-control" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.email")}}</label>
                                        <input type="text" id="email" name="email" required class="form-control" value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.phone")}}</label>
                                        <input type="text" id="phone" name="phone" required class="form-control" value="{{$user->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.password")}}</label>
                                        <input type="password" id="pwd" name="pwd"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.share")}}</label>
                                        <input type="text" id="sh_holder" name="sh_holder" required value="{{$user->shareholder_no}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.civil")}}</label>
                                        <input type="text" id="civil" name="civil" required class="form-control" value="{{$user->civil_id}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.action")}}</label>
                                        <select class="form-control" name="action" id="action">
                                        <option value='0'>--Select--</option>
                                        <option value="Block" {{($user->action == "Block") ? 'selected' : ''}}>Block</option>
                                        <option value="Freeze" {{($user->action == "Freeze") ? 'selected' : ''}}>Freeze</option>
                                        <option value="Reject" {{($user->action == "Reject") ? 'selected' : ''}}>Reject</option>
                                        <option value="Inactive" {{($user->action == "Inactive") ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.role")}}</label>
                                        <select class="form-control" name="role" id="role">
                                        <option value='0'>--Select--</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if($user->role != null) @if($role->id == $user->role) selected @endif @endif>{{$role->name}}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <input type="checkbox" id="ge_reports" name="ge_reports"   @if($user->generate_reports == 'Y') checked  @endif>   
                                 
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
