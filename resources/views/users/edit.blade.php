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
                                <h4 class="card-title ">{{ __("jamia.emp") }}</h4>
                               
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
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="phone" name="phone" required class="form-control" value="{{$user->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.password")}}</label>
                                        <input type="password" id="pwd" name="pwd"  class="form-control">
                                    </div>
                                </div>
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
