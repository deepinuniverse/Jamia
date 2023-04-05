@extends('layouts.app', ['activePage' => 'branches', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.brch")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/branches" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/branches/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{$branch->name}}"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.branch")}}</label>
                                        <select class="form-control" name="branch_cat" required id="branch_cat" >
                                        <option value='0'>--Select--</option>
                                        @foreach($branchCat as $cat)
                                        <option value="{{$cat->id}}" @if($branch->branch_categories_id != 0) @if($cat->id == $branch->branch_categories_id) selected @endif @endif>{{$cat->name}}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.address")}}</label>
                                        <input type="text" id="address" name="address"  class="form-control" value="{{$branch->address}}" required>

                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="contact" name="contact"  class="form-control" value="{{$branch->phone}}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.hours")}}</label>
                                        <input type="text" id="hour" name="hour"  class="form-control" value="{{$branch->hours}}" required>
                                </div> 
                                <div class="col-md-6">
                                    <input type="file" name="img">
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
