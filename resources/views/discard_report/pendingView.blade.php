 <div class="modal-dialog pending_list_body" id="pending_list_body" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="margin-left: 166px;"><b>{{ __("jamia.discard") }}</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <input type="hidden" name="discard_id" id="discard_id" value="{{$discard->id}}">
          @if(empty($discard->item_photo))
          @else
          <tr><td> <img width="375" height="175" src="{{$discard->item_photo}}" alt="image" ></td></tr>
          @endif
          <tr><td>{{ __("jamia.item")}}: {{$discard->item_name}}</td></tr>
          <tr><td>{{ __("jamia.jamia_name")}}: {{$discard->jamia_name}}</td></tr>
          <tr><td>{{ __("jamia.cust_cont")}}: {{$discard->customer_contact}}</td></tr>
          <tr><td>{{ __("jamia.rpt_details")}}: {{$discard->customer_note}}</td></tr>
          <tr><td>{{ __("jamia.admin_exp")}}: <textarea class="form-control" id="admin_not" name="admin_not" ></textarea></td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success admin_reply" id="DONE">{{ __("jamia.aprove")}}</button>
      </div>
    </div>
</div>