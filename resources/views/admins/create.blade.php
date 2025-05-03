@extends('layouts.apps')

@section('content')
<div class="container">
    <h3>Create Admin</h3>

    <form method="POST" action="{{ route('admins.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="tester" id="testerCheckbox">
            <label class="form-check-label" for="testerCheckbox">Add Tester</label>
        </div>

        <div class="row mb-3" id="adminSelect" style="display: none;">
            <div class="col-sm-10">
                <select name="user_assigned_by[]" multiple>
                    <option selected="">Open this select menu</option>
                    @foreach ($unassignedAdmins as $val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success">Create</button>
        <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<!-- Add this in the <head> or just before the closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#testerCheckbox').change(function() {
            if ($(this).is(':checked')) {
                $('#adminSelect').show(); // Show the dropdown
            } else {
                $('#adminSelect').hide(); // Hide the dropdown
            }
        });
    });
</script>
@endsection