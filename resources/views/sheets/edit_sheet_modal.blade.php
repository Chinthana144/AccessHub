<div class="modal" tabindex="-1" id="edit_sheet_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="hide_sheet_id" id="hide_sheet_id">
      
        <div class="modal-body">
            <input type="date" name="start_date">
        </div>

        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="button" class="btn btn-primary">Update Sheet</button>
        </div>
      </form>

    </div>
  </div>
</div>