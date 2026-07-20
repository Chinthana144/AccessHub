<div class="modal" tabindex="-1" id="add_user_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('users.store') }}" method="post">
        @csrf
        <div class="modal-body">
            <label for="">Role</label>
            <select name="cmb_role" id="cmb_role" class="form-select">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <label for="">Name</label>
            <input type="text" name='name' class="form-control mb-3" required>

            <label for="">Email</label>
            <input type="email" name='email' class="form-control mb-3" required>

            <label for="">Password</label>
            <input type="password" name='password' id="password" class="form-control mb-3" required>
            
            <label for="">Re-enter Password</label>
            <input type="password" name='re_password' id="re_password" class="form-control mb-3" required>

        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>

    </div>
  </div>
</div>