<div class="modal" tabindex="-1" id="edit_pwd_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('users.updatePassword') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="pwd_change_id" id="pwd_change_id">
        <div class="modal-body">
            <p id="p_user_data"></p>

            <label for="">New Password</label>
            <input type="password" name='new_password' id="new_password" class="form-control mb-3" required>
            
            <label for="">Re-enter Password</label>
            <input type="password" name='new_re_password' id="new_re_password" class="form-control mb-3" required>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
      </form>

    </div>
  </div>
</div>