<div class="modal" tabindex="-1" id="campEditModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Camp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route("camps.update") }}" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="hide_camp_id" id="hide_camp_id" value="0">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Camp Name</label>
                    <input type="text" name="name" id="name" class="form-control mb-2" required>

                    <label for="">Address</label>
                    <input type="text" name="address" id="address" class="form-control mb-2" required>

                    <label for="">Contact Person</label>
                    <input type="text" name="contactPerson" id="contactPerson" class="form-control mb-2" required>

                    <label for="">Contact No</label>
                    <input type="text" name="contactNo" id="contactNo" class="form-control mb-2" required>

                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="chk_edit_upload_sheet" name="chk_edit_upload_sheet">
                      <label class="form-check-label" for="chk_edit_upload_sheet">Upload Sheets</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="">Mikrotik Host</label>
                    <input type="text" name="mikrotikHost" id="mikrotikHost" class="form-control mb-2" required>

                    <label for="">Mikrotik Port</label>
                    <input type="text" name="mikrotikPort" id="mikrotikPort" class="form-control mb-2" required>

                    <label for="">Mikrotik Username</label>
                    <input type="text" name="mikrotikUsername" id="mikrotikUsername" class="form-control mb-2" required>

                    <label for="">Mikrotik Password</label>
                    <input type="text" name="mikrotikPassword" id="mikrotikPassword" class="form-control mb-2" required>

                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="chk_edit_active" name="chk_edit_active">
                      <label class="form-check-label" for="chk_edit_active">Active</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="">Google Sheet ID</label>
                    <input type="text" name="sheetID" id="sheetID" class="form-control mb-2" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Update Camp</button>
        </div>
      </form>

    </div>
  </div>
</div>