<div class="modal" tabindex="-1" id="edit_permission_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Permission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="" method="post">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Select Role</label>
                    <select name="cmb_edit_role" id="cmb_edit_role" class="form-select">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">Select page</label>
                    <select name="cmb_edit_page" id="cmb_edit_page" class="form-select">
                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}">{{ $page->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <p>Create Permission</p>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_edit_create" name="chk_edit_create">
                        <label class="form-check-label" for="chk_edit_create">Create</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_edit_edit" name="chk_edit_edit">
                        <label class="form-check-label" for="chk_edit_edit">Edit</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_edit_view" name="chk_edit_view">
                        <label class="form-check-label" for="chk_edit_view">View</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_edit_delete" name="chk_edit_delete">
                        <label class="form-check-label" for="chk_edit_delete">Delete</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Add Permission</button>
        </div>
      </form>

    </div>
  </div>
</div>