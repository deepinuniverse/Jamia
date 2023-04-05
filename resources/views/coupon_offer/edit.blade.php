@extends('layouts.app', ['activePage' => 'couponoffer', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title ">{{ __("jamia.coupon_offer")}}</h4>
                            </div>
                            <div>
                                <a class="btn btn-success" href="/coupon_offer" style="display: inline;"><strong><i class="fa fa-backward fa-lg"></i></strong></a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body p-4">
                        <form action="/coupon_offer/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="coupon_id" value="{{$coupon->id}}">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{$coupon->offer_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="contact" name="contact"  class="form-control" value="{{$coupon->contact_no}}" required>
                                    </div>
                                </div>
                                <div class="col-md-12 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.description")}}</label>
                                        <textarea class="form-control" id="details" name="details" >{{$coupon->description}}</textarea>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.from")}}</label>
                                        <input type="date" id="from" value="{{$coupon->from_dt}}" name="from" class="form-control">
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.to")}}</label>
                                        <input type="date" id="to" value="{{$coupon->to_dt}}" name="to" class="form-control">
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.offer_cat")}}</label>
                                        <select class="form-control" name="offer_cat" required id="offer_cat" >
                                        <option value='0'>--Select--</option>
                                        @foreach($offer_cat as $offer)
                                        <option value="{{$offer->id}}" @if($coupon->offer_categories_id != 0) @if($offer->id == $coupon->offer_categories_id) selected @endif @endif>{{$offer->name}}</option>
                                        @endforeach
                                       </select>
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
