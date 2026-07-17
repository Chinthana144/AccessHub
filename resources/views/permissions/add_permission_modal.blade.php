<div class="modal" tabindex="-1" id="add_permission_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Permission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('permission.store') }}" method="post">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Select Role</label>
                    <select name="cmb_role" id="cmb_role" class="form-select">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">Select page</label>
                    <select name="cmb_page" id="cmb_page" class="form-select">
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
                        <input class="form-check-input" type="checkbox" id="chk_create" name="chk_create">
                        <label class="form-check-label" for="chk_create">Create</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_edit" name="chk_edit">
                        <label class="form-check-label" for="chk_edit">Edit</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_view" name="chk_view">
                        <label class="form-check-label" for="chk_view">View</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="chk_delete" name="chk_delete">
                        <label class="form-check-label" for="chk_delete">Delete</label>
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