@extends('layouts.app', ['activePage' => 'gallery', 'titlePage' => __('')])

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
                        <form action="/galleries" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.name")}}</label>
                                        <input type="text" id="nm" name="name"  class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 eng_sh">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.date")}}</label>
                                        <input type="date" id="g_date" name="g_date"  class="form-control" value="{{date('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __("jamia.status")}}</label>
                                        <select class="form-control" name="status" required id="status" >
                                        <option value='0'>--Select--</option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <label for="name">{{ __("jamia.main")}}</label>
                                  <input type="file" name="img"></br></br>
                                  <table class="img_tab">  
                                    <tr><td><input type="file" name="images[]" multiple><button type="button" class="add_img btn-success"><i class='fa fa-plus'></i></button></td></tr>
                                  </table>
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
@section('js')
    <script>
      
      $(document).on("click",".add_img", function() {
         $('.img_tab').after("<tr><td><input type='file' name='images[]' multiple><button type='button' class='add_img btn-success'><i class='fa fa-plus'></i></button></td><td><button type='button' class='delete_img btn-danger'><i class='fa fa-trash' ></i></button></td></tr>");
      });
       $(document).on("click",".delete_img", function() {
         $(this).closest("tr").remove();
      });
    </script>
@endsection
