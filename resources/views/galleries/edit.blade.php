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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.status")}}</label>
                                        <select class="form-control status" name="status" required id="status" >
                                        <option value='0'>--Select--</option>
                                        <option value="Active" {{($gallery->status == "Active") ? 'selected' : ''}}>Active</option>
                                        <option value="InActive" {{($gallery->status == "InActive") ? 'selected' : ''}}>InActive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                <label for="name">{{ __("jamia.main")}}</label>
                                  <input type="file" name="img"></br></br>
                                <table class="img_tab"> 
                                <tbody>
                                @if(count($gal_images) != 0)
                                @foreach($gal_images as $gal)
                                <tr>
                                    <td><img width="75" height="75"  src="{{$gal->photo}}" alt="image" class="g_img" id="{{$gal->id}}"></td>
                                    <td><button type="button" class="img_delete btn-danger" id="{{$gal->id}}"><i class='fa fa-trash'></i></button></td>
                                </tr>
                                @endforeach
                                @endif
                                <tr><td><input type="file" name="images[]" multiple></td>
                                    <td><button type="button" class="add_img btn-success"><i class='fa fa-plus'></i></button></td>
                                </tr>
                                </tbody> 
                                </table>
                                </div>
                                </br>
                                
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
              
      
      $(document).on("click",".add_img", function() {
         $('.img_tab tbody').append("<tr><td><input type='file' name='images[]' multiple><button type='button' class='add_img btn-success'><i class='fa fa-plus'></i></button></td><td><button type='button' class='delete_img btn-danger'><i class='fa fa-trash' ></i></button></td></tr>");
      });
       $(document).on("click",".delete_img", function() {
         $(this).closest("tr").remove();
      });
      $(document).on("click",".img_delete", function() {
        var id = $(this).attr("id"); 
          if(confirm("Do you want to delete this Image?") == true){
            
            $.getJSON("/galley/photo/destroy/" + id, (response) => {

            });
           
            $(this).closest("tr").remove();
          }
         
      });
    </script>
@endsection

