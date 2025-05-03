@extends('layouts.apps')

@section('content')

<div class="pagetitle">
    <h1>Admin List</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admins.index')}}">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active">Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Button to open modal -->


    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admins.bulkAssign') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel">Assign Users to Me</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="users">Select Users:</label>
                        <select name="user_ids[]" id="users" class="form-select" multiple required>
                            @foreach($unassignedAdmins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign Selected</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datatables</h5>
                    <a href="{{ route('admins.create') }}" class="btn btn-primary mb-3">Create Admin</a>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->role }}</td>
                                <td>
                                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this admin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>

                                    <!-- @if($admin->id)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal">
                                        Assign Users
                                    </button>
                                    @endif -->
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>




@endsection