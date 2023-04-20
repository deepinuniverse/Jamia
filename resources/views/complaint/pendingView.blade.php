 <div class="modal-dialog pending_list_body" id="pending_list_body" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="margin-left: 166px;"><b>{{ __("jamia.complaint") }}</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <input type="hidden" name="complaint_id" id="complaint_id" value="{{$complaint->id}}">
          <tr><td>{{ __("jamia.customer")}}: {{$complaint->name}}</td></tr>
          <tr><td>{{ __("jamia.cust_phone")}}: {{$complaint->number}}</td></tr>
          <tr><td>{{ __("jamia.email")}}: {{$complaint->email}}</td></tr>
          <tr><td>{{ __("jamia.description")}}: {{$complaint->notes}}</td></tr>
          <tr><td>{{ __("jamia.admin_exp")}}: <textarea class="form-control" id="admin_not" name="admin_not" ></textarea></td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success admin_reply" id="DONE">{{ __("jamia.aprove")}}</button>
      </div>
    </div>
</div>