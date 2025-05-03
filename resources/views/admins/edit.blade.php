@extends('layouts.apps')

@section('content')
<div class="container">
    <h3>Edit Admin</h3>

    <form method="POST" action="{{ route('admins.update', $admin->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
        </div>

        <div class="mb-3">
            <label>New Password (Optional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="tester" id="testerCheckbox" {{ $admin->role == 'tester' ? 'checked' : '' }}>
            <label class="form-check-label" for="testerCheckbox">Add Tester</label>
        </div>

        @php
        $assigned = explode(',', $admin->assigned_admins ?? '');
        @endphp

        <div class="row mb-3" id="adminSelect" style="{{ $admin->role == 'tester' ? '' : 'display: none;' }}">
            <div class="col-sm-10">
                <select name="user_assigned_by[]" class="form-control" multiple>
                    @foreach ($unassignedAdmins as $val)
                    <option value="{{ $val->id }}" {{ in_array($val->id, $assigned) ? 'selected' : '' }}>
                        {{ $val->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#testerCheckbox').change(function () {
            if ($(this).is(':checked')) {
                $('#adminSelect').show();
            } else {
                $('#adminSelect').hide();
            }
        });
    });
</script>

@endsection