<div class="modal" tabindex="-1" id="code_edit_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('codes.update') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="code_edit_id" id="code_edit_id">
        <div class="modal-body">
            <p id="p_code_details"></p>

            <label for="">Date</label>
            <input type="date" name="issue_date" id="issue_date" class="form-control">

            <label for="">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control">

            <label for="">Room No</label>
            <input type="text" name="room_no" id="room_no" class="form-control">

            <label for="">Amount</label>
            <input type="text" name="amount" id="amount" class="form-control">

            <label for="">Note</label>
            <input type="text" name="note" id="note" class="form-control">
        </div>

        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Update Code</button>
        </div>
      </form>

    </div>
  </div>
</div>