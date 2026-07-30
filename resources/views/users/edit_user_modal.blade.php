<div class="modal" tabindex="-1" id="edit_user_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('users.update') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="hide_user_id" id="hide_user_id">
        <div class="modal-body">
            <label for="">Role</label>
            <select name="cmb_edit_role" id="cmb_edit_role" class="form-select">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <label for="">Name</label>
            <input type="text" name='edit_name' id="edit_name" class="form-control mb-3" required>

            <label for="">Email</label>
            <input type="email" name='edit_email' id="edit_email" class="form-control mb-3" required>

        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </form>

    </div>
  </div>
</div>