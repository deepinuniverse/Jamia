@extends('layouts.app', ['activePage' => 'discardReport', 'titlePage' => __('')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    	<div class="card-header card-header-primary">
                        	<div class="d-flex justify-content-between">
                            	<div>
                                	<h4 class="card-title ">{{ __("jamia.discard") }}</h4>
                            	</div>
                            	<div>
                                	<a class="btn btn-success" href="/discard_report/create">{{ __("jamia.cr_discard") }}</a>
                            	</div>
                        	</div>
                      	</div>
                      	<div class="card-body">
                        	<div class="table-responsive">
                          		<table class="table" id="data-table">
									<thead class=" text-primary">
										<th>{{__("jamia.sl_no")}}</th>
                                        <th>{{__("jamia.item")}}</th>
                                        <th>{{__("jamia.cust_phone")}}</th>
                                        <th>{{__("jamia.jamia_name")}}</th>
                                        <th>{{__("jamia.date")}}</th>
                                        <th>{{__("jamia.status")}}</th>
										<th>{{__("jamia.image")}}</th>
										<th>{{__("jamia.action") }}</th>
									</thead>
									<tbody><?php $i=1; ?>
										@foreach ($reports as $report)
                    
											<tr>
												<td>{{ $i++; }}</td>
                                                <td>{{ $report->item_name }}</td>
                                                <td>{{ $report->customer_contact }}</td>
                                                <td>{{ $report->jamia_name }}</td>
                                                <td>{{ date('d-m-Y',strtotime($report->report_dt)) }}</td>
                                                <td>{{ $report->status }}</td>
												<td>
													<img width="75" height="75" src="{{$report->item_photo}}" alt="image">
												</td>
												<td>
													<a  href="/discard_report/{{$report->id}}/edit" rel="tooltip" title={{__("edit") }} class="btn btn-success btn-simple btn-xs">
                         <i class="fa fa-edit"></i></a>								
                         <button type="button"  rel="tooltip" title={{ __("delete") }} class="btn btn-danger btn-simple btn-xs delete" id="{{$report->id}}"><i class="fa fa-times"></i></button>
                         <a  href="/news/view/{{$report->id}}" rel="tooltip" title={{__("view") }} class="btn btn-success btn-simple btn-xs">
                         <i class="fa fa-eye"></i></a> 
                        </td>
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
          if(confirm("Do you want to delete this Discard Report?") == true){

            var url = '/discard_report/destroy/' + id; 
            window.location= url;
          }
      });
    </script>
@endsection
