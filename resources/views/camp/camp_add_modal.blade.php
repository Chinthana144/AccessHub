<div class="modal" tabindex="-1" id="campAddModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Camp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('camps.store') }}" method="post">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Camp Name</label>
                    <input type="text" name="name" class="form-control mb-2" required>

                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control mb-2" required>

                    <label for="">Contact Person</label>
                    <input type="text" name="contactPerson" class="form-control mb-2" required>

                    <label for="">Contact No</label>
                    <input type="text" name="contactNo" class="form-control mb-2" required>

                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="chk_upload_sheet" name="chk_upload_sheet">
                      <label class="form-check-label" for="chk_upload_sheet">Upload Sheets</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="">Mikrotik Host</label>
                    <input type="text" name="mikrotikHost" class="form-control mb-2" required>

                    <label for="">Mikrotik Port</label>
                    <input type="text" name="mikrotikPort" class="form-control mb-2" required>

                    <label for="">Mikrotik Username</label>
                    <input type="text" name="mikrotikUsername" class="form-control mb-2" required>

                    <label for="">Mikrotik Password</label>
                    <input type="text" name="mikrotikPassword" class="form-control mb-2" required>

                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="chk_active" name="chk_active" checked>
                      <label class="form-check-label" for="chk_active">Active</label>
                    </div>
                </div>

                <div class="col-md-12 mt-2">
                    <label for="">Google Sheet ID</label>
                    <input type="text" name="sheetID" class="form-control mb-2" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Create Camp</button>
        </div>
      </form>

    </div>
  </div>
</div>