<div class="modal" tabindex="-1" id="edit_sheet_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('update.sheet') }}" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="hide_sheet_id" id="hide_sheet_id">
      
        <div class="modal-body">
            <p id="p_last_sync">last sync date</p>

            <div class="row">
                <div class="col-md-6">
                  <label for="">Month Start</label>
                  <input type="date" name="start_date" id="edit_start_date" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="">Month End</label>
                  <input type="date" name="end_date" id="edit_end_date" class="form-control">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="chk_has_code" id="chk_has_code">
                      <label class="form-check-label" for="chk_has_code">Has code in sheet</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="chk_active_sheet" id="chk_active_sheet">
                      <label class="form-check-label" for="chk_active_sheet">Active Sheet</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Update Sheet</button>
        </div>
      </form>

    </div>
  </div>
</div>