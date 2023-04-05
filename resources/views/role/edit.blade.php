@extends('layouts.app', ['activePage' => 'role', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.role") }}</h4>
                               
                            </div>
                            <div>
                                <a class="btn btn-success" href="/roles"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/roles/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="role_id" value="{{$role->id}}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name" required class="form-control" value="{{$role->name}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.permission")}}</label><br>
                                        @foreach($permissions as $permission)
                                        <label>
                                         @if(in_array($permission->id,$role_permission))   
                                           <input type="checkbox" name="permisssion[]" value="{{$permission->id}}" checked>
                                           {{$permission->name}}
                                        </label><br>
                                        @else
                                        <input type="checkbox" name="permisssion[]" value="{{$permission->id}}" >
                                           {{$permission->name}}
                                        </label><br>
                                        @endif
                                        @endforeach
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
