@extends('layouts.app', ['activePage' => 'gallery', 'titlePage' => __('')])
<style type="text/css">
    .img-wrap {
    position: relative;
    ...
}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    ...
}
</style>
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
                        <form action="/galleries/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="nm" name="name"  class="form-control" value="{{$gallery->title}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="g_date" name="g_date"  class="form-control" value="{{$gallery->date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.status")}}</label>
                                        <select class="form-control status" name="status" required id="status" >
                                        <option value='0'>--Select--</option>
                                        <option value="Active" {{($gallery->status == "Active") ? 'selected' : ''}}>Active</option>
                                        <option value="InActive" {{($gallery->status == "InActive") ? 'selected' : ''}}>InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="xy" name="images[]" multiple>
                                </div>
                                @if(count($gal_images) != 0)
                                @foreach($gal_images as $gal)
                                <div class="img-wrap">
                                  
                                  <span class="close g_img"  id="{{$gal->id}}" style="display: none;">&times;</span>
                                  <img width="75" height="75"  src="{{$gal->photo}}" alt="image" class="g_img" id="{{$gal->id}}">
                                </div>
                                </br>
                                @endforeach
                                @endif
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
@section('js')
    <script >
              
      $(document).on("change",".status", function() {alert(0);
         var  = $(this).attr("id"); 
          if(confirm("Do you want to delete this Image?") == true){
            $(this).remove();
            $.getJSON("/galley/photo/destroy/" + id, (response) => {
                alert(0);
            });

          }
      });
    </script>
@endsection

