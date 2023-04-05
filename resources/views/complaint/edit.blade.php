@extends('layouts.app', ['activePage' => 'complaint', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.complaint")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/complaints" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/complaints/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="complaints_id" value="{{$complaint->id}}">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.customer")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{$complaint->name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="contact" name="contact"  class="form-control" value="{{$complaint->number}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.email")}}</label>
                                        <input type="text" id="email" name="email"  class="form-control" value="{{$complaint->email}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.reason")}}</label>
                                        <select class="form-control" name="reason" required id="reason" >
                                        <option value='0'>--Select--</option>
                                        <option value="Suggestion" {{($complaint->reason == "Suggestion") ? 'selected' : ''}}>Suggestion</option>
                                        <option value="Complaint"  {{($complaint->reason == "Complaint") ? 'selected' : ''}}>Complaint</option>
                                        <option value="Question" {{($complaint->reason == "Question") ? 'selected' : ''}}>Question</option>
                                        <option value="Other" {{($complaint->reason == "Other") ? 'selected' : ''}}>Other</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.description")}}</label>
                                        <textarea class="form-control" id="details" name="details" >{{$complaint->notes}}</textarea>

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
