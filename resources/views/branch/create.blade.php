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
                        <form action="/branches" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="name" name="name"  class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.branch")}}</label>
                                        <select class="form-control" name="branch_cat" required id="branch_cat" >
                                        <option value='0'>--Select--</option>
                                        @foreach($branchCat as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.address")}}</label>
                                        <input type="text" id="address" name="address"  class="form-control" required>

                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.cust_phone")}}</label>
                                        <input type="text" id="contact" name="contact"  class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.hours")}}</label>
                                        <input type="text" id="hour" name="hour"  class="form-control" required>
                                     </div>   
                                </div> 
                                <div class="col-md-6">
                                    <input type="file" name="img">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.latitude")}}</label>
                                        <input type="text" class="form-control" placeholder="lat" name="lat" id="lat">
                                     </div>   
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.longitude")}}</label>
                                        <input type="text" class="form-control" placeholder="lng" name="lng" id="lng">
                                     </div>   
                                </div> 
                                <div id="map" style="height:400px; width: 800px;" class="my-3"></div>
                                
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
@section('js')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
                        type="text/javascript"></script>
<script>
                    let map;
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: { lat: -34.397, lng: 150.644 },
                            zoom: 8,
                            scrollwheel: true,
                        });

                        const uluru = { lat: -34.397, lng: 150.644 };
                        let marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            draggable: true
                        });

                        google.maps.event.addListener(marker,'position_changed',
                            function (){
                                let lat = marker.position.lat()
                                let lng = marker.position.lng()
                                $('#lat').val(lat)
                                $('#lng').val(lng)
                            })

                        google.maps.event.addListener(map,'click',
                        function (event){
                            pos = event.latLng
                            marker.setPosition(pos)
                        })
                    }
                </script>                        
@endsection
