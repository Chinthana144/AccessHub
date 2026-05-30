<div class="modal" tabindex="-1" id="addAccessModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Camp Access</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('campAccess.store') }}" method="post">
        @csrf
        <div class="modal-body">
            <label for="">User</label>
            <select name="user_id" id="" class="form-select mb-2">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <label for="">Camp</label>
            <select name="camp_id" id="" class="form-select mb-2">
                @foreach ($camps as $camp)
                    <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary">Create Access</button>
        </div>
      </form>

    </div>
  </div>
</div>