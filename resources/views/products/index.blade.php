@extends('layouts.app', ['activePage' => 'products', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.product") }}</h4>
                            	</div>
                            	<div>
                                    
                                	<a class="btn btn-success" href="/products/delete">{{ __("jamia.delete") }}</a>
                            	</div>
                        	</div>
                      	</div><br>
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                        <form action="/products/upload" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6" style="display:inline;">
                                    <input type="file" name="data" required>
                                </div>
                            <div class="col-md-6 p-3" style="display:inline;">
                                    <input type="submit" value="{{ __("jamia.upload") }}" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                      	<div class="card-body">
                            
                        	<div class="table-responsive" style="display:none;">
                                
                          		<table class="table" id="data-table" >
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.it_bar")}}</th>
                                        <th>{{__("jamia.it_co")}}</th>
										<th>{{__("jamia.item")}}</th>
										<th>{{__("jamia.it_pr") }}</th>
                                        <th>{{__("jamia.vendor") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($products as $product)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $product->ItemBarcode }}</td>
                                                <td>{{ $product->ItemCode }}</td>
                                                <td>{{ $product->ItemName }}</td>
                                                <td>{{ $product->ItemPrice }}</td>
                                                <td>{{ $product->vendor }}</td>
                                            </tr>
										@endforeach
									</tbody>
                          		</table>
                        	</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
      $(document).ready( function () {
          $('#data-table').DataTable();
        } 
      );
      $(document).on("click",".delete", function() {
         var id = $(this).attr("id"); 
          if(confirm("Do you want to delete this Director?") == true){

            var url = '/directors/delete/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
